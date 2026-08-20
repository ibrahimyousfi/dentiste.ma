<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Subscription Plan') }}: {{ $subscriptionPlan->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.subscription-plans.update', $subscriptionPlan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Info -->
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Plan Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $subscriptionPlan->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring-[#39D3C4] sm:text-sm" required>
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="price_monthly" class="block text-sm font-medium text-gray-700">Monthly Price ($)</label>
                                    <input type="number" step="0.01" name="price_monthly" id="price_monthly" value="{{ old('price_monthly', $subscriptionPlan->price_monthly) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring-[#39D3C4] sm:text-sm" required>
                                    @error('price_monthly') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="price_yearly" class="block text-sm font-medium text-gray-700">Yearly Price ($)</label>
                                    <input type="number" step="0.01" name="price_yearly" id="price_yearly" value="{{ old('price_yearly', $subscriptionPlan->price_yearly) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring-[#39D3C4] sm:text-sm" required>
                                    @error('price_yearly') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="limit_users" class="block text-sm font-medium text-gray-700">Users Limit (Leave empty for Unlimited)</label>
                                    <input type="number" name="limit_users" id="limit_users" value="{{ old('limit_users', $subscriptionPlan->limit_users) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring-[#39D3C4] sm:text-sm">
                                    @error('limit_users') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="limit_patients" class="block text-sm font-medium text-gray-700">Patients Limit (Leave empty for Unlimited)</label>
                                    <input type="number" name="limit_patients" id="limit_patients" value="{{ old('limit_patients', $subscriptionPlan->limit_patients) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring-[#39D3C4] sm:text-sm">
                                    @error('limit_patients') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="flex items-center mt-4">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $subscriptionPlan->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-[#39D3C4] focus:ring-[#39D3C4]">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Active Plan (Show to users)</label>
                                </div>
                            </div>

                            <!-- Features -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Features</h3>
                                <div class="space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    @php
                                        $featuresList = [
                                            'appointments' => 'Appointments Calendar',
                                            'dental_chart' => 'Dental Chart',
                                            'invoices' => 'Invoices & Billing',
                                            'whatsapp_notifications' => 'WhatsApp Notifications',
                                            'advanced_dental_chart' => 'Advanced Dental Chart',
                                            'inventory' => 'Inventory Management',
                                            'recalls' => 'Patient Recalls',
                                            'laboratory' => 'Laboratory Cases',
                                        ];
                                    @endphp

                                    @foreach($featuresList as $key => $label)
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" name="features[{{ $key }}]" id="feature_{{ $key }}" value="1" 
                                                    {{ old('features.'.$key, data_get($subscriptionPlan->features, $key, false)) ? 'checked' : '' }}
                                                    class="focus:ring-[#39D3C4] h-4 w-4 text-[#39D3C4] border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="feature_{{ $key }}" class="font-medium text-gray-700">{{ $label }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <a href="{{ route('admin.subscription-plans.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4] mr-3">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#39D3C4] hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4]">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
