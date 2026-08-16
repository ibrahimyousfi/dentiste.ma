<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Patient;

class VoiceNoteController extends Controller
{
    public function transcribe(Request $request, Patient $patient)
    {
        $request->validate([
            'audio' => 'required|file|mimes:webm,wav,mp3,mp4,mpeg,mpga,m4a,ogg|max:25000',
        ]);

        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'OpenAI API key not configured in .env'
            ], 400);
        }

        $audioFile = $request->file('audio');

        // Step 1: Transcribe the audio using Whisper
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->attach(
            'file', file_get_contents($audioFile->getRealPath()), $audioFile->getClientOriginalName()
        )->post('https://api.openai.com/v1/audio/transcriptions', [
            'model' => 'whisper-1',
            // optional: 'language' => 'ar' // Let it auto-detect or take from request later
        ]);

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Error transcribing audio: ' . $response->body()
            ], 500);
        }

        $transcription = $response->json('text');

        // Step 2: Format the transcription using GPT-4
        $prompt = "You are an expert dental assistant. You will receive a raw, unstructured voice transcription from a dentist. " .
                  "Your job is to format it into a clean, professional clinical note. " .
                  "Fix any grammatical errors, medical term misspellings, and organize it logically (e.g., Diagnosis, Treatment, Next Steps). " .
                  "Keep the language of the final output the SAME as the input language (e.g. if the input is Arabic, output Arabic). " .
                  "Do not add extra conversational filler. Return ONLY the formatted clinical note.\n\n" .
                  "Raw Transcription:\n" . $transcription;

        $gptResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.2,
        ]);

        $finalNote = $transcription; // Fallback

        if ($gptResponse->successful()) {
            $finalNote = $gptResponse->json('choices.0.message.content') ?? $transcription;
        }

        return response()->json([
            'success' => true,
            'original_text' => $transcription,
            'formatted_text' => trim($finalNote)
        ]);
    }
}
