<div class="p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Referral Links</h2>
        <div class="flex gap-4">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search..."
                class="px-4 py-2 border rounded-lg"
            >
            <select 
                wire:model.live="perPage" 
                class="px-4 py-2 border rounded-lg"
            >
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
            </select>
        </div>
    </div>

    @if (session()->has('message'))
        <div 
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
        >
            {{ session('message') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trainer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($links as $link)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $link->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $link->trainer_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $link->trainer_email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $link->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a 
                                href="{{ route('referral.handle', $link->code) }}" 
                                target="_blank"
                                class="text-blue-600 hover:text-blue-800"
                            >
                                View Link
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $link->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button 
                                wire:click="deleteReferralLink({{ $link->id }})"
                                class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Are you sure you want to delete this referral link?')"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $links->links() }}
    </div>
</div>
