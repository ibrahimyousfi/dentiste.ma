<x-kiosk-layout>
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" x-data="kioskForm()">
        
        <!-- Header -->
        <div class="bg-gray-50 border-b border-gray-100 p-8 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black text-gray-900">Hello, {{ $patient->first_name }}!</h2>
                <p class="text-gray-500 font-medium mt-1">Please review and complete your check-in details.</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Appointment Today</p>
                <p class="text-2xl font-black text-[#39D3C4]">{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</p>
            </div>
        </div>

        <form action="{{ route('kiosk.submit') }}" method="POST" id="kiosk-form" class="p-8 md:p-12">
            @csrf
            
            <div class="mb-12">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-[#39D3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Medical History Update
                </h3>
                
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Do you have any new allergies, medications, or medical conditions we should know about?</label>
                    <textarea name="medical_history" rows="4" class="shadow-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] block w-full sm:text-lg border-gray-200 rounded-xl bg-white p-4 text-gray-800" placeholder="Type here, or leave blank if there are no changes...">{{ $patient->medical_history }}</textarea>
                </div>
            </div>

            <div class="mb-12">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-[#39D3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Digital Signature
                </h3>
                
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 text-center">
                    <p class="text-sm font-medium text-gray-500 mb-4">Please sign below to confirm your medical history and consent for today's treatment.</p>
                    
                    <div class="border-2 border-dashed border-gray-300 bg-white rounded-xl overflow-hidden touch-none relative mx-auto" style="width: 100%; max-width: 500px; height: 200px;">
                        <canvas x-ref="signaturePad" class="w-full h-full cursor-crosshair"></canvas>
                    </div>
                    
                    <div class="mt-4 flex justify-center">
                        <button type="button" @click="clearSignature" class="text-sm font-bold text-red-500 hover:text-red-700">Clear Signature</button>
                    </div>
                    
                    <input type="hidden" name="signature_data" x-ref="signatureInput">
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('kiosk.index') }}" class="px-8 py-4 border border-gray-300 rounded-2xl text-lg font-bold text-gray-700 bg-white hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="button" @click="submitForm" class="px-10 py-4 border border-transparent rounded-2xl text-lg font-black text-white bg-[#39D3C4] hover:bg-[#2db3a6] shadow-lg shadow-[#39D3C4]/30 transition-all hover:-translate-y-1">
                    Complete Check-In
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('kioskForm', () => ({
                signaturePad: null,

                init() {
                    const canvas = this.$refs.signaturePad;
                    
                    // Resize canvas to fix blurriness on high DPI screens
                    function resizeCanvas() {
                        const ratio =  Math.max(window.devicePixelRatio || 1, 1);
                        canvas.width = canvas.offsetWidth * ratio;
                        canvas.height = canvas.offsetHeight * ratio;
                        canvas.getContext("2d").scale(ratio, ratio);
                    }
                    
                    window.addEventListener("resize", resizeCanvas);
                    resizeCanvas();

                    this.signaturePad = new SignaturePad(canvas, {
                        penColor: "rgb(15, 23, 42)", // Dark Slate
                        backgroundColor: "rgba(255, 255, 255, 1)"
                    });
                },

                clearSignature() {
                    this.signaturePad.clear();
                },

                submitForm() {
                    if (this.signaturePad.isEmpty()) {
                        alert("Please provide a signature before checking in.");
                        return;
                    }
                    
                    // Save signature data to hidden input
                    this.$refs.signatureInput.value = this.signaturePad.toDataURL("image/png");
                    
                    // Submit the form
                    document.getElementById('kiosk-form').submit();
                }
            }));
        });
    </script>
    @endpush
</x-kiosk-layout>
