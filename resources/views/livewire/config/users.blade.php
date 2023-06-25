<div wire:init="loadUsers">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- table -->
                @include('livewire.config.edit-users')
                <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
                    <div class="px-6 py-4 flex items-center">
                        <div class="flex items-center">
                            <span class="">Mostrar</span>
                            <select class="mx-2 form-select rounded-md" wire:model="cant">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span class="">entradas</span>
                        </div>
                        <x-input type="text" class="flex-1 mx-4" placeholder="Busca: Nombre o Email" wire:model="search" />
                        @livewire('config.create-users')
                    </div>
                    @if (count($users))
                        
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" wire:click="order('name')"
                                        class="cursor-pointer px-6 py-4 font-medium text-gray-900">
                                        Nombre
                                        {{-- Sort de la columna --}}
                                        @if ($sort == 'name')
                                            @if ($direction == 'asc')
                                                <i class="fa-solid fa-arrow-up-a-z float-right mt-1"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down-z-a float-right mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-sort float-right mt-1"></i>
                                        @endif
                                    </th>
                                    <th scope="col" wire:click="order('email')"
                                        class="cursor-pointer px-6 py-4 font-medium text-gray-900">Rol
                                        {{-- Sort de la columna --}}
                                        @if ($sort == 'email')
                                            @if ($direction == 'asc')
                                                <i class="fa-solid fa-arrow-up-a-z float-right mt-1"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down-z-a float-right mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-sort float-right mt-1"></i>
                                        @endif
                                    </th>
                                    <th scope="col"
                                        class="cursor-pointer px-6 py-4 font-medium text-gray-900 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ($users as $item)
                                    <tr class="hover:bg-gray-50">
                                        <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                                            <div class="relative h-10 w-10">
                                                <img class="h-full w-full rounded-full object-cover object-center"
                                                    src="{{ asset('img/pngfind.com-placeholder-png-6104451.png') }}"
                                                    alt="" />
                                                <span
                                                    class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
                                            </div>
                                            <div class="text-sm">
                                                <div class="font-medium text-gray-700">{{ $item->name }}</div>
                                                <div class="text-gray-400">{{ $item->email }}</div>
                                            </div>
                                        </th>
                                        <td class="px-6 py-4">Product Designer</td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-4">
                                            <a x-data="{ tooltip: 'Edite' }" href="#" wire:click="edit({{ $item}}, '{{ $item->name }}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="h-6 w-6" x-tooltip="tooltip">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                </a>
                                                <a x-data="{ tooltip: 'Delete' }" href="#"  wire:click="$emit('evtDeleteUser', {{$item->id}})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="h-6 w-6" x-tooltip="tooltip">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </a>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if($users->hasPages(2))
                            <div class="px-6 py-3">
                                {{ $users->links() }}
                            </div>
                        @endif
                        
                    @else
                        <div class="px-6 py-4">
                            No coincide con nuestros registros.
                        </div>
                    @endif

                    
                </div>
                <!-- fin table -->
            </div>
        </div>
    </div>
    
</div>
@push('scripts')
        <script>
            
            Livewire.on('evtDeleteUser', id => {
                Swal.fire({
                    title: '¿Estas seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, bórralo!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('deleteUser', id)
                        Swal.fire(
                        '¡Eliminado!',
                        'El registro fue eliminado.',
                        'success'
                        )
                    }
                })
            })
        </script>
    @endpush

