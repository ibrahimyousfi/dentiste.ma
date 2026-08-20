<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.organizations.index') }}" class="p-2 bg-[#1e293b] border border-[#334155] text-slate-400 hover:text-white rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Edit Clinic: {{ $organization->name }}</h1>
                <p class="text-slate-400 mt-1">Update clinic contact details and SaaS subscription plan.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        
        <div class="max-w-4xl bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg overflow-hidden">
            
            <form action="{{ route('admin.organizations.update', $organization) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-6">
                    <!-- General Details -->
                    <div>
                        <h3 class="text-lg font-bold text-white mb-4 border-b border-[#334155] pb-2">Clinic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Clinic Name *</label>
                                <input type="text" name="name" value="{{ old('name', $organization->name) }}" required class="w-full bg-[#0f172a] border border-[#334155] rounded-lg px-4 py-2.5 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition">
                                @error('name')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Primary Email</label>
                                <input type="email" name="email" value="{{ old('email', $organization->email) }}" class="w-full bg-[#0f172a] border border-[#334155] rounded-lg px-4 py-2.5 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition">
                                @error('email')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $organization->phone) }}" class="w-full bg-[#0f172a] border border-[#334155] rounded-lg px-4 py-2.5 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition">
                                @error('phone')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Address</label>
                                <input type="text" name="address" value="{{ old('address', $organization->address) }}" class="w-full bg-[#0f172a] border border-[#334155] rounded-lg px-4 py-2.5 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition">
                                @error('address')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Subscription Details -->
                    <div class="pt-6">
                        <h3 class="text-lg font-bold text-white mb-4 border-b border-[#334155] pb-2">SaaS Plan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Subscription Tier *</label>
                                <select name="subscription_plan_id" class="w-full bg-[#0f172a] border border-[#334155] rounded-lg px-4 py-2.5 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition">
                                    <option value="">Select a plan</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" {{ (old('subscription_plan_id', $currentPlanId) == $plan->id) ? 'selected' : '' }}>
                                            {{ $plan->name }} (${{ $plan->price_monthly }}/mo)
                                        </option>
                                    @endforeach
                                </select>
                                @error('subscription_plan_id')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                                <p class="text-xs text-slate-400 mt-2">Changing the plan here will immediately update the clinic's limits and features.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="p-6 border-t border-[#334155] bg-[#0f172a]/50 flex justify-end gap-3">
                    <a href="{{ route('admin.organizations.index') }}" class="px-5 py-2.5 bg-[#1e293b] border border-[#334155] text-white font-medium rounded-lg hover:bg-[#334155] transition">Cancel</a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-500 transition">Save Changes</button>
                </div>

            </form>

        </div>
    </div>
</x-admin-layout>
