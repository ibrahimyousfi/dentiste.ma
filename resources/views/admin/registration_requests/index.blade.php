<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registration Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clinic & Owner</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($requests as $req)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $req->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $req->clinic_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $req->owner_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><a href="mailto:{{ $req->email }}" class="text-indigo-600 hover:underline">{{ $req->email }}</a></div>
                                        <div class="text-sm text-gray-500"><a href="tel:{{ $req->phone }}" class="text-indigo-600 hover:underline">{{ $req->phone }}</a></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.registration-requests.update-status', $req->id) }}" method="POST">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="text-sm rounded border-gray-300 {{ $req->status == 'pending' ? 'bg-amber-50 text-amber-700' : ($req->status == 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700') }}">
                                                <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="contacted" {{ $req->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                                <option value="completed" {{ $req->status == 'completed' ? 'selected' : '' }}>Completed (Clinic Created)</option>
                                                <option value="rejected" {{ $req->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('admin.registration-requests.destroy', $req->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this request?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No registration requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $requests->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
