<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ __('Billing & Subscription') }}
        </h2>
    </x-slot>

    <div class="animate-fade-in max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 rounded-xl font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-8 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-600 rounded-xl font-medium">
                {{ session('error') }}
            </div>
        @endif
        
        @if($pendingRequest)
            <div class="mb-8 p-4 bg-amber-500/10 border border-amber-500/20 text-amber-600 rounded-xl font-medium flex flex-col md:flex-row items-center justify-between">
                <div>
                    <span class="font-bold">Pending Upgrade:</span> You have requested to upgrade to the <strong>{{ $pendingRequest->plan->name }}</strong> plan. Please complete the bank transfer. Once verified, the administration will activate your plan.
                </div>
            </div>
        @endif

        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Pricing that scales with your clinic
            </h1>
            <p class="mt-4 text-xl text-gray-500">
                You are currently on the <span class="font-bold text-[#39D3C4]">{{ $currentSubscription->plan->name ?? 'None' }}</span> Plan.
            </p>
        </div>

        <!-- Subscription Status Card -->
        @if($currentSubscription)
        <div class="max-w-3xl mx-auto bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-16">
            <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Current Subscription Status</h3>
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $currentSubscription->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($currentSubscription->status) }}
                </span>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Started At</div>
                        <div class="font-medium text-gray-900">{{ $currentSubscription->starts_at ? $currentSubscription->starts_at->format('M d, Y') : 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Ends At</div>
                        <div class="font-medium text-gray-900">{{ $currentSubscription->ends_at ? $currentSubscription->ends_at->format('M d, Y') : 'Lifetime' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Days Elapsed</div>
                        <div class="font-bold text-[#39D3C4]">{{ $daysElapsed }} / {{ $totalDays }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Days Remaining</div>
                        <div class="font-bold text-indigo-600">{{ $daysRemaining }}</div>
                    </div>
                </div>
                
                @if($totalDays > 0)
                <div>
                    <div class="flex justify-between text-xs font-medium text-gray-500 mb-1">
                        <span>Progress</span>
                        <span>{{ round($percentage) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-[#39D3C4] h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
            @php
                $org = auth()->user()->organization;
                $currency = $org->currency ?? 'USD';
                
                // Simple static exchange rates from USD
                $exchangeRates = [
                    'USD' => 1,
                    'MAD' => 9.25,
                    'EUR' => 0.92,
                    'GBP' => 0.79,
                ];
                $rate = $exchangeRates[$currency] ?? 1;
                $currencySymbol = match($currency) {
                    'MAD' => 'MAD ',
                    'EUR' => '€',
                    'GBP' => '£',
                    default => '$',
                };
            @endphp
            @foreach($plans as $plan)
                @php
                    $isCurrent = $currentSubscription && $currentSubscription->subscription_plan_id === $plan->id;
                    $isPending = $pendingRequest && $pendingRequest->subscription_plan_id === $plan->id;
                @endphp
                
                <div class="relative p-8 bg-white border border-gray-200 rounded-3xl shadow-sm flex flex-col transition-transform transform hover:-translate-y-1 {{ $plan->slug === 'pro' ? 'ring-2 ring-[#39D3C4] z-10 scale-105' : '' }}">
                    
                    @if($plan->slug === 'pro')
                        <div class="absolute top-0 right-0 transform translate-x-2 -translate-y-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold tracking-wide uppercase bg-gradient-to-r from-[#39D3C4] to-[#2BA99B] text-white shadow-sm">
                                Most Popular
                            </span>
                        </div>
                    @endif

                    <div class="mb-5">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h3>
                        <div class="mt-4 flex items-baseline text-5xl font-extrabold">
                            {{ $currencySymbol }}{{ number_format($plan->price_monthly * $rate, 2) }}
                            <span class="ml-1 text-xl font-medium text-gray-500">/mo</span>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-4 flex-1">
                        <li class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <p class="ml-3 text-base text-gray-700">{{ $plan->limit_patients ? $plan->limit_patients . ' Patients Limit' : 'Unlimited Patients' }}</p>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <p class="ml-3 text-base text-gray-700">{{ $plan->limit_users ? $plan->limit_users . ' Staff Members Limit' : 'Unlimited Staff' }}</p>
                        </li>
                        @foreach($plan->features ?? [] as $feature => $enabled)
                            @if($enabled)
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <p class="ml-3 text-base text-gray-700">{{ ucwords(str_replace('_', ' ', $feature)) }}</p>
                            </li>
                            @endif
                        @endforeach
                    </ul>

                    <div class="mt-8">
                        @if($isCurrent)
                            <button disabled class="w-full bg-gray-100 text-gray-500 font-bold rounded-xl py-3 px-4 border border-gray-200 cursor-not-allowed">
                                Current Plan
                            </button>
                        @elseif($isPending)
                            <button disabled class="w-full bg-amber-100 text-amber-600 font-bold rounded-xl py-3 px-4 border border-amber-200 cursor-not-allowed">
                                Request Pending
                            </button>
                        @else
                            <form action="{{ route('clinic.subscription.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <input type="hidden" name="payment_method" value="bank_transfer">
                                <button type="submit" class="w-full block text-center rounded-xl py-3 px-4 font-bold text-white shadow-sm hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $plan->slug === 'pro' ? 'bg-[#39D3C4] focus:ring-[#39D3C4]' : 'bg-gray-900 focus:ring-gray-900' }}">
                                    Upgrade via Bank Transfer
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
    </div>
</x-app-layout>
