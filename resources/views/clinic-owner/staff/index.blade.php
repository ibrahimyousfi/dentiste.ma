<x-app-layout>
    <x-slot name="header_search">
        <form action="{{ route('staff.index') }}" method="GET" class="w-full">
            <x-ui.search name="search" value="{{ request('search') }}" placeholder="Search staff by name or email..." />
        </form>
    </x-slot>

    <x-slot name="header_actions">
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-staff-drawer')">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            New
        </x-ui.button>
    </x-slot>

    <div class="animate-fade-in pb-10">
        @if(session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl relative shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if($staffMembers->isEmpty())
            <x-ui.card class="p-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#39D3C4]/10 mb-4 text-[#39D3C4]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No staff members found</h3>
                <p class="text-gray-500 text-sm max-w-sm mx-auto mb-6">Get started by adding a new staff member to your clinic.</p>
                <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-staff-drawer')">
                    Add Staff Member
                </x-ui.button>
            </x-ui.card>
        @else
            <x-ui.row-list>
                @foreach($staffMembers as $staff)
                    <x-ui.row-card>
                        <!-- Left: Staff Avatar, Name & Roles -->
                        <div class="flex items-center gap-3.5 min-w-[240px]">
                            <div class="h-11 w-11 rounded-2xl bg-gradient-to-br from-[#39D3C4]/15 to-blue-500/15 text-gray-800 flex items-center justify-center font-bold text-sm border border-[#39D3C4]/20 shrink-0 shadow-2xs">
                                {{ substr($staff->name, 0, 2) }}
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-bold text-gray-900 truncate">
                                        {{ $staff->name }}
                                    </h3>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($staff->roles as $role)
                                        @php
                                            $variant = match($role->name) {
                                                'Clinic Owner' => 'emerald',
                                                'Dentist' => 'blue',
                                                'Secretary' => 'amber',
                                                'Assistant' => 'purple',
                                                default => 'teal',
                                            };
                                        @endphp
                                        <x-ui.badge variant="{{ $variant }}" size="xs">{{ $role->name }}</x-ui.badge>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Middle 1: Contact Info -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-6 min-w-[260px] text-xs text-gray-600">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span class="truncate font-medium text-gray-800">{{ $staff->email }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span class="text-gray-500">{{ $staff->phone ?? 'No phone' }}</span>
                            </div>
                        </div>

                        <!-- Middle 2: Clinic Assignment -->
                        <div class="hidden md:block min-w-[120px] text-xs">
                            <span class="text-gray-400 block text-[10px] uppercase font-semibold">Location</span>
                            <span class="font-medium text-gray-700">Main Clinic</span>
                        </div>

                        <!-- Right: Actions -->
                        <div class="flex items-center gap-2 shrink-0">
                            <button @click="$dispatch('open-edit-staff', { id: {{ $staff->id }}, name: '{{ addslashes($staff->name) }}', email: '{{ addslashes($staff->email) }}', role: '{{ $staff->roles->first()?->name ?? '' }}' })" class="p-1.5 rounded-lg text-gray-400 hover:text-sky-600 hover:bg-sky-50 transition-colors" title="Edit Profile">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none" title="More Actions">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="#" @click.prevent="$dispatch('open-edit-staff', { id: {{ $staff->id }}, name: '{{ addslashes($staff->name) }}', email: '{{ addslashes($staff->email) }}', role: '{{ $staff->roles->first()?->name ?? '' }}' })">Edit Profile</x-dropdown-link>
                                    <x-dropdown-link href="#">Manage Permissions</x-dropdown-link>
                                    <x-dropdown-link href="#">View Schedule</x-dropdown-link>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    @if($staff->id !== Auth::id())
                                        <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" class="w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 text-rose-600 hover:bg-rose-50 focus:outline-none transition duration-150 ease-in-out" onclick="return confirm('Are you sure you want to deactivate or remove this staff member?');">
                                                Deactivate / Remove
                                            </button>
                                        </form>
                                    @endif
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </x-ui.row-card>
                @endforeach
            </x-ui.row-list>
        @endif
    </div>

    <!-- Create Staff Drawer -->
    <x-ui.drawer id="create-staff-drawer" title="Add New Staff Member">
        <form id="create-staff-form" method="POST" action="{{ route('staff.store') }}">
            @csrf
            
            <div class="space-y-6">
                <div class="mb-2">
                    <p class="text-sm text-gray-500">Personal and account details for the staff member.</p>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                    
                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">System Role <span class="text-red-500">*</span></label>
                        <select id="role" name="role" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                            <option value="" disabled selected>Select a role...</option>
                            <option value="Clinic Owner">Doctor / Clinic Owner</option>
                            <option value="Secretary">Secretary / Receptionist</option>
                            <option value="Dentist">Dentist</option>
                            <option value="Assistant">Assistant</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 mb-2 border-t border-gray-200 pt-4">
                    <p class="text-sm font-medium text-gray-900 mb-1">Security</p>
                    <p class="text-xs text-gray-500">Set the initial password for this staff member.</p>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
            <x-ui.button variant="primary" x-on:click="document.getElementById('create-staff-form').submit()">Save Staff</x-ui.button>
        </x-slot>
    </x-ui.drawer>

    <!-- Edit Staff Drawer -->
    <div x-data="{
        editForm: { id: '', name: '', email: '', role: '' },
        actionUrl: '',
        init() {
            window.addEventListener('open-edit-staff', (e) => {
                this.editForm = e.detail;
                // Dynamically build the update route
                this.actionUrl = '{{ url('clinic/staff') }}/' + this.editForm.id;
                this.$dispatch('open-drawer', 'edit-staff-drawer');
            });
        }
    }">
        <x-ui.drawer id="edit-staff-drawer" title="Edit Staff Member">
            <form id="edit-staff-form" method="POST" :action="actionUrl">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" x-model="editForm.name" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" x-model="editForm.email" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                        </div>
                        
                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">System Role <span class="text-red-500">*</span></label>
                            <select name="role" x-model="editForm.role" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                                <option value="Clinic Owner">Doctor / Clinic Owner</option>
                                <option value="Secretary">Secretary / Receptionist</option>
                                <option value="Dentist">Dentist</option>
                                <option value="Assistant">Assistant</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 mb-2 border-t border-gray-200 pt-4">
                        <p class="text-sm font-medium text-gray-900 mb-1">Change Password (Optional)</p>
                        <p class="text-xs text-gray-500">Leave blank if you do not want to change the password.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" name="password" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                        </div>
                    </div>
                </div>
            </form>

            <x-slot name="footer">
                <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
                <x-ui.button variant="primary" x-on:click="document.getElementById('edit-staff-form').submit()">Update Staff</x-ui.button>
            </x-slot>
        </x-ui.drawer>
    </div>
</x-app-layout>
