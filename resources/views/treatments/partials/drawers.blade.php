<!-- Edit Treatment Plan Drawer -->
<x-ui.drawer id="edit-plan-drawer-{{ $plan->id }}" title="Edit Treatment Plan">
    <form id="edit-plan-form-{{ $plan->id }}" action="{{ route('treatment-plans.update', $plan) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="name-{{ $plan->id }}" class="block text-sm font-medium text-gray-700 mb-1">Treatment Plan Title <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name-{{ $plan->id }}" value="{{ old('name', $plan->name) }}" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                </div>

                <div>
                    <label for="total_estimated_cost-{{ $plan->id }}" class="block text-sm font-medium text-gray-700 mb-1">Total Estimated Cost ($) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" name="total_estimated_cost" id="total_estimated_cost-{{ $plan->id }}" value="{{ old('total_estimated_cost', $plan->total_estimated_cost) }}" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                </div>
                
                <div>
                    <label for="notes-{{ $plan->id }}" class="block text-sm font-medium text-gray-700 mb-1">Clinical Notes & Summary</label>
                    <textarea id="notes-{{ $plan->id }}" name="notes" rows="4" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">{{ old('notes', $plan->notes) }}</textarea>
                </div>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
        <x-ui.button variant="primary" x-on:click="document.getElementById('edit-plan-form-{{ $plan->id }}').submit()">Save Changes</x-ui.button>
    </x-slot>
</x-ui.drawer>

<!-- Add Session Drawer -->
<x-ui.drawer id="add-session-drawer-{{ $plan->id }}" title="Add Treatment Session">
    <form id="add-session-form-{{ $plan->id }}" action="{{ route('treatment-plans.sessions.store', $plan) }}" method="POST">
        @csrf
        
        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="session_date-{{ $plan->id }}" class="block text-sm font-medium text-gray-700 mb-1">Session Date <span class="text-red-500">*</span></label>
                    <input type="date" name="session_date" id="session_date-{{ $plan->id }}" value="{{ date('Y-m-d') }}" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                </div>
                
                <div>
                    <label for="clinical_notes-{{ $plan->id }}" class="block text-sm font-medium text-gray-700 mb-1">Session Notes</label>
                    <textarea id="clinical_notes-{{ $plan->id }}" name="clinical_notes" rows="4" placeholder="Record what was done during this session..." class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm"></textarea>
                </div>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
        <x-ui.button variant="primary" x-on:click="document.getElementById('add-session-form-{{ $plan->id }}').submit()">Save Session</x-ui.button>
    </x-slot>
</x-ui.drawer>

<!-- Record Payment Drawer -->
<x-ui.drawer id="add-payment-drawer-{{ $plan->id }}" title="Record Payment">
    <form id="add-payment-form-{{ $plan->id }}" action="{{ route('payments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="treatment_plan_id" value="{{ $plan->id }}">
        <input type="hidden" name="patient_id" value="{{ $plan->patient_id }}">
        
        <div class="space-y-6">
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center justify-between mb-4">
                <div>
                    <span class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Remaining Balance</span>
                    <span class="text-xl font-bold text-gray-900">${{ number_format($plan->total_estimated_cost - ($plan->amount_paid ?? 0), 2) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="amount-{{ $plan->id }}" class="block text-sm font-medium text-gray-700 mb-1">Payment Amount ($) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" max="{{ $plan->total_estimated_cost - ($plan->amount_paid ?? 0) }}" name="amount" id="amount-{{ $plan->id }}" required placeholder="0.00" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                </div>

                <div>
                    <label for="payment_method-{{ $plan->id }}" class="block text-sm font-medium text-gray-700 mb-1">Payment Method <span class="text-red-500">*</span></label>
                    <select name="payment_method" id="payment_method-{{ $plan->id }}" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                        <option value="cash">Cash</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="insurance">Insurance</option>
                    </select>
                </div>
                
                <div>
                    <label for="payment_date-{{ $plan->id }}" class="block text-sm font-medium text-gray-700 mb-1">Payment Date <span class="text-red-500">*</span></label>
                    <input type="date" name="payment_date" id="payment_date-{{ $plan->id }}" value="{{ date('Y-m-d') }}" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                </div>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
        <x-ui.button variant="primary" x-on:click="document.getElementById('add-payment-form-{{ $plan->id }}').submit()">Record Payment</x-ui.button>
    </x-slot>
</x-ui.drawer>
