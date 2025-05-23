<x-videos-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-red-600">
                <h1 class="text-xl font-bold text-white">❌ Eliminar Usuari</h1>
            </div>

            <div class="p-6">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                Estàs segur que vols eliminar aquest usuari? Aquesta acció no es pot desfer.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 border border-gray-200 rounded-md mb-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Informació de l'usuari</h2>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Nom</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Rol</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @foreach($user->getRoleNames() as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ ucfirst($role) }}
                                    </span>
                                @endforeach
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Data de creació</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'No disponible' }}</dd>
                        </div>
                    </dl>
                </div>

                <form action="{{ route('users.manage.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('users.manage.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-arrow-left mr-2"></i> Cancel·lar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-trash-alt mr-2"></i> Confirmar Eliminació
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-videos-app-layout>
