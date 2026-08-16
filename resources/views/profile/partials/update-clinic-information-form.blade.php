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
