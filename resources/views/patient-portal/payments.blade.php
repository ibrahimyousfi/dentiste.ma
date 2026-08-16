@extends('layouts.patient')

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 text-center py-20">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-green-50 text-green-500 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Financial Records</h2>
        <p class="text-gray-500 max-w-md mx-auto">Your payment history will appear here.</p>
    </div>
</div>
@endsection
