<div x-data="{
    conditions: {
        hypertension: false,
        diabetes: false,
        allergies: true,
        heart_disease: false,
        bleeding_disorder: false,
        asthma: false
    }
}">
    <form action="#" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Chronic Conditions -->
            <div>
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Chronic Conditions</h4>
                <div class="space-y-4">
                    
                    <template x-for="(value, key) in conditions" :key="key">
                        <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors">
                            <span class="text-sm font-medium text-gray-700 capitalize" x-text="key.replace('_', ' ')"></span>
                            <button type="button" @click="conditions[key] = !conditions[key]" :class="conditions[key] ? 'bg-[#39D3C4]' : 'bg-gray-200'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#39D3C4] focus:ring-offset-2">
                                <span :class="conditions[key] ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" :name="'conditions['+key+']'" :value="conditions[key] ? 1 : 0">
                        </div>
                    </template>

                </div>
            </div>

            <!-- Notes & Medications -->
            <div>
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Details & Medications</h4>
                
                <div class="space-y-5">
                    <!-- Allergies Details -->
                    <div x-show="conditions.allergies" x-transition.opacity>
                        <label for="allergies_note" class="block text-sm font-medium text-gray-700 mb-1">List Allergies</label>
                        <input type="text" name="allergies_note" id="allergies_note" placeholder="e.g., Penicillin, Latex" value="Penicillin" class="block w-full rounded-xl border-gray-300 bg-red-50 text-red-900 focus:ring-red-500 focus:border-red-500 shadow-sm sm:text-sm">
                    </div>

                    <!-- Current Medications -->
                    <div>
                        <label for="medications" class="block text-sm font-medium text-gray-700 mb-1">Current Medications</label>
                        <textarea id="medications" name="medications" rows="3" placeholder="List all current medications..." class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:ring-[#39D3C4] focus:border-[#39D3C4] shadow-sm sm:text-sm transition-colors"></textarea>
                    </div>

                    <!-- General Medical Notes -->
                    <div>
                        <label for="medical_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Medical Notes</label>
                        <textarea id="medical_notes" name="medical_notes" rows="3" class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:ring-[#39D3C4] focus:border-[#39D3C4] shadow-sm sm:text-sm transition-colors"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-[#39D3C4] hover:bg-[#2db3a6] border border-transparent rounded-xl font-bold text-sm text-white shadow-sm shadow-[#39D3C4]/30 focus:outline-none focus:ring-2 focus:ring-[#39D3C4] focus:ring-offset-2 transition-all">
                Save Health Profile
            </button>
        </div>
    </form>
</div>
