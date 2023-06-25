<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Maps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
                        <x-input type="text" class="flex-1 mx-4" placeholder="Busca: Nombre" />
                        
                        <a class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('mapas.create')}}">
                        <i class="fa-solid fa-plus mt-1"></i>
                        </a>
                    </div>
                    @if (count($mapas))
                        
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" wire:click="order('name')"
                                        class="cursor-pointer px-6 py-4 font-medium text-gray-900">
                                        Nombre
                                    </th>
                                    <th scope="col" wire:click="order('name')"
                                        class="cursor-pointer px-6 py-4 font-medium text-gray-900">
                                        Categoría
                                    </th>
                                    <th scope="col"
                                        class="cursor-pointer px-6 py-4 font-medium text-gray-900 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ($mapas as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $item->name }}</td>
                                        <td class="px-6 py-4">{{ $item->category->name }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-4">
                                            <a x-data="{ tooltip: 'Ver' }" href="{{ route('mapas.show', ['mapa' => $item->id])}}" >
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" class="h-6 w-6"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                                                </a>
                                            <!-- <a x-data="{ tooltip: 'Edite' }" href="#" >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="h-6 w-6" x-tooltip="tooltip">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                </a> -->
                                                <a x-data="{ tooltip: 'Delete' }" href="#"  class="eliminar" onclick="Eliminar({{$item->id}})">
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

                        @if($mapas->hasPages(2))
                            <div class="px-6 py-3">
                                {{ $mapas->links() }}
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
    @push('scripts')

<script>
    let sleep = function(ms){
    return new Promise(resolve => setTimeout(resolve, ms));
};

    const Eliminar = (id) => {
        Swal.fire({
  title: '¿Estas seguro?',
  text: "¡No podrás revertir esto!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: '¡Sí, bórralo!'
}).then(async(result) => {
  if (result.isConfirmed) {
    let result = await axios.delete(`mapas/${id}`);
    if(result.data.state === "done") {
        Swal.fire(
        '¡Eliminado!',
        `El registro ${result.data.name} ha sido eliminado con exito.`,
        'success'
        );
        await sleep(2000);
        location.reload();
    }
    
  }
})
        
    }
</script>
@endpush
</x-app-layout>