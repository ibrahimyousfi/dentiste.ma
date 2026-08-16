<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Clinic Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your clinic's name, contact info, and logo.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updateClinic') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="clinic_name" :value="__('Clinic Name')" />
            <x-text-input id="clinic_name" name="name" type="text" class="mt-1 block w-full" :value="old('name', auth()->user()->organization->name)" required autofocus autocomplete="organization" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="clinic_phone" :value="__('Clinic Phone (Optional)')" />
            <x-text-input id="clinic_phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', auth()->user()->organization->phone)" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="clinic_address" :value="__('Clinic Address (Optional)')" />
            <x-text-input id="clinic_address" name="address" type="text" class="mt-1 block w-full" :value="old('address', auth()->user()->organization->address)" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="clinic_logo" :value="__('Clinic Logo (Max 2MB)')" />
            
            @if(auth()->user()->organization->logo)
                <div class="mt-2 mb-4">
                    <p class="text-sm text-gray-500 mb-2">Current Logo:</p>
                    <img src="{{ Storage::url(auth()->user()->organization->logo) }}" alt="Clinic Logo" class="h-16 rounded-lg border border-gray-200">
                </div>
            @endif

            <input id="clinic_logo" name="logo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#39D3C4]/10 file:text-[#39D3C4] hover:file:bg-[#39D3C4]/20" />
            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
        </div>
        
        <hr class="border-gray-100 my-6">
        
        <h3 class="text-md font-medium text-gray-900 mb-4">Localization Settings</h3>

        <div>
            <x-input-label for="currency" :value="__('Currency')" />
            <select id="currency" name="currency" class="mt-1 block w-full border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] rounded-md shadow-sm">
                <option value="USD" @selected(old('currency', auth()->user()->organization->currency) == 'USD')>US Dollar (USD)</option>
                <option value="EUR" @selected(old('currency', auth()->user()->organization->currency) == 'EUR')>Euro (EUR)</option>
                <option value="MAD" @selected(old('currency', auth()->user()->organization->currency) == 'MAD')>Moroccan Dirham (MAD)</option>
                <option value="GBP" @selected(old('currency', auth()->user()->organization->currency) == 'GBP')>British Pound (GBP)</option>
                <option value="CAD" @selected(old('currency', auth()->user()->organization->currency) == 'CAD')>Canadian Dollar (CAD)</option>
                <option value="AUD" @selected(old('currency', auth()->user()->organization->currency) == 'AUD')>Australian Dollar (AUD)</option>
                <option value="AED" @selected(old('currency', auth()->user()->organization->currency) == 'AED')>UAE Dirham (AED)</option>
                <option value="SAR" @selected(old('currency', auth()->user()->organization->currency) == 'SAR')>Saudi Riyal (SAR)</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('currency')" />
        </div>

        <div>
            <x-input-label for="timezone" :value="__('Timezone')" />
            <select id="timezone" name="timezone" class="mt-1 block w-full border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] rounded-md shadow-sm">
                <option value="UTC" @selected(old('timezone', auth()->user()->organization->timezone) == 'UTC')>UTC</option>
                <option value="Africa/Casablanca" @selected(old('timezone', auth()->user()->organization->timezone) == 'Africa/Casablanca')>Casablanca (Morocco)</option>
                <option value="Europe/Paris" @selected(old('timezone', auth()->user()->organization->timezone) == 'Europe/Paris')>Paris (France)</option>
                <option value="America/New_York" @selected(old('timezone', auth()->user()->organization->timezone) == 'America/New_York')>New York (USA)</option>
                <option value="Asia/Dubai" @selected(old('timezone', auth()->user()->organization->timezone) == 'Asia/Dubai')>Dubai (UAE)</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
        </div>

        <div>
            <x-input-label for="date_format" :value="__('Date Format')" />
            <select id="date_format" name="date_format" class="mt-1 block w-full border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] rounded-md shadow-sm">
                <option value="Y-m-d" @selected(old('date_format', auth()->user()->organization->date_format) == 'Y-m-d')>YYYY-MM-DD (2026-12-31)</option>
                <option value="d/m/Y" @selected(old('date_format', auth()->user()->organization->date_format) == 'd/m/Y')>DD/MM/YYYY (31/12/2026)</option>
                <option value="m/d/Y" @selected(old('date_format', auth()->user()->organization->date_format) == 'm/d/Y')>MM/DD/YYYY (12/31/2026)</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('date_format')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Clinic Settings') }}</x-primary-button>

            @if (session('status') === 'clinic-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
