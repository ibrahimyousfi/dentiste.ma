<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ __('Billing & Subscription') }}
        </h2>
    </x-slot>

    <div class="animate-fade-in max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Pricing that scales with your clinic
            </h1>
            <p class="mt-4 text-xl text-gray-500">
                You are currently on the <span class="font-bold text-[#39D3C4]">{{ $organization->subscription_plan ?? 'Basic' }}</span> Plan.
            </p>
            @if($organization->subscription_ends_at)
                <p class="mt-2 text-sm text-gray-400">
                    Your next billing date is {{ \Carbon\Carbon::parse($organization->subscription_ends_at)->format('F j, Y') }}.
                </p>
            @endif
        </div>

        <div class="space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
            @foreach($plans as $planName => $details)
                @php
                    $isCurrent = ($organization->subscription_plan ?? 'Basic') === $planName;
                @endphp
                
                <div class="relative p-8 bg-white border border-gray-200 rounded-3xl shadow-sm flex flex-col transition-transform transform hover:-translate-y-1 {{ $planName === 'Pro' ? 'ring-2 ring-[#39D3C4] z-10 scale-105' : '' }}">
                    
                    @if($planName === 'Pro')
                        <div class="absolute top-0 right-0 transform translate-x-2 -translate-y-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold tracking-wide uppercase bg-gradient-to-r from-[#39D3C4] to-[#2BA99B] text-white shadow-sm">
                                Most Popular
                            </span>
                        </div>
                    @endif

                    <div class="mb-5">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $planName }}</h3>
                        <div class="mt-4 flex items-baseline text-5xl font-extrabold">
                            ${{ $details['price'] }}
                            <span class="ml-1 text-xl font-medium text-gray-500">/mo</span>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-4 flex-1">
                        @foreach($details['features'] as $feature)
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-base text-gray-700">{{ $feature }}</p>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-8">
                        @if($isCurrent)
                            <button disabled class="w-full bg-gray-100 text-gray-500 font-bold rounded-xl py-3 px-4 border border-gray-200 cursor-not-allowed">
                                Current Plan
                            </button>
                        @else
                            <form action="{{ route('clinic.subscription.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="{{ $planName }}">
                                <button type="submit" class="w-full block text-center rounded-xl py-3 px-4 font-bold text-white shadow-sm hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $planName === 'Pro' ? 'bg-[#39D3C4] focus:ring-[#39D3C4]' : 'bg-gray-900 focus:ring-gray-900' }}">
                                    Upgrade to {{ $planName }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
    </div>
</x-app-layout>
