<div>
    @if ($isOpen)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-gray-50 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">First
                                Name:</label>
                            <p class="text-gray-700 text-lg">{{ $user->first_name }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">Last Name:</label>
                            <p class="text-gray-700 text-lg">{{ $user->last_name }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:</label>
                            <p class="text-gray-700 text-lg">{{ $user->email }}</p>
                        </div>
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="membership">Membership:</label>
    @if ($user->membership === null)
        <p class="text-gray-700 text-lg">Not Subscribed to any membership</p>
    @else
        <div class="flex justify-between items-center">
            <p class="text-gray-700 text-lg">{{ $user->membership }}</p>
            <button wire:click="unsubscribe" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Unsubscribe
            </button>
        </div>
    @endif
</div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="street">Street:</label>
                            <div class="flex items-center">
                                @if ($editable['street'])
                                    <input type="text" wire:model="street" wire:keydown.enter="saveField('street')"
                                        wire:click.away="saveField('street')"
                                        class="text-gray-700 text-lg bg-white rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        autofocus />
                                @else
                                    <p class="text-gray-700 text-lg">{{ $user->street ?? 'Not Available' }}</p>
                                @endif
                                <svg onclick="makeEditable('street')" class="w-4 h-4 ml-2 text-gray-500 cursor-pointer"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" wire:click="enableEdit('street')">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L12 18H9v-3L16.732 5.232z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="city">City:</label>
                            <div class="flex items-center">
                                @if ($editable['city'])
                                    <input type="text" wire:model="city" wire:keydown.enter="saveField('city')"
                                        wire:click.away="saveField('city')"
                                        class="text-gray-700 text-lg bg-white rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        autofocus />
                                @else
                                    <p class="text-gray-700 text-lg">{{ $user->city ?? 'Not Available' }}</p>
                                @endif
                                <svg onclick="makeEditable('city')" class="w-4 h-4 ml-2 text-gray-500 cursor-pointer"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" wire:click="enableEdit('city')">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L12 18H9v-3L16.732 5.232z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="state">State:</label>
                            <div class="flex items-center">
                                @if ($editable['state'])
                                    <input type="text" wire:model="state" wire:keydown.enter="saveField('state')"
                                        wire:click.away="saveField('state')"
                                        class="text-gray-700 text-lg bg-white rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        autofocus />
                                @else
                                    <p class="text-gray-700 text-lg">{{ $user->state ?? 'Not Available' }}</p>
                                @endif
                                <svg onclick="makeEditable('state')" class="w-4 h-4 ml-2 text-gray-500 cursor-pointer"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" wire:click="enableEdit('state')">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L12 18H9v-3L16.732 5.232z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="zip">ZIP Code:</label>
                            <div class="flex items-center">
                                @if ($editable['zip'])
                                    <input type="text" wire:model="zip" wire:keydown.enter="saveField('zip')"
                                        wire:click.away="saveField('zip')"
                                        class="text-gray-700 text-lg bg-white rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        autofocus />
                                @else
                                    <p class="text-gray-700 text-lg">{{ $user->zip ?? 'Not Available' }}</p>
                                @endif
                                <svg onclick="makeEditable('zip')" class="w-4 h-4 ml-2 text-gray-500 cursor-pointer"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" wire:click="enableEdit('zip')">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L12 18H9v-3L16.732 5.232z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <button type="button" wire:click="$set('isOpen', false)"
                            class="absolute top-0 right-0 text-red-500 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center ">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div class="absolute bottom-0 right-0 m-4">
                            <button wire:click="logout"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
