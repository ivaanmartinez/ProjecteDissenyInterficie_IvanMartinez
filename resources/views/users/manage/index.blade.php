<x-videos-app-layout>
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-bold mb-4 md:mb-0">Gestió d'Usuaris</h1>

            <!-- Botó destacat per crear usuari -->
            <a href="{{ route('users.manage.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-transform duration-200 hover:scale-105" data-qa="create-user">
                <i class="fas fa-plus mr-2"></i> Crear Usuari
            </a>
        </div>

        <!-- Missatge de sessió -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p class="font-bold">Èxit:</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Filtres i cerca -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <form action="{{ route('users.manage.index') }}" method="GET" class="md:flex md:items-end md:space-x-4">
                <div class="flex-1 mb-4 md:mb-0">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cerca</label>
                    <input type="text" name="search" id="search" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Nom o email..." value="{{ request('search') }}" data-qa="input-search">
                </div>

                <div class="mb-4 md:mb-0 md:w-1/4">
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Ordenar per</label>
                    <select name="sort" id="sort" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" data-qa="select-sort">
                        <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Data creació (més recent)</option>
                        <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Data creació (més antic)</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                    </select>
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-qa="button-filter">
                        <i class="fas fa-search mr-2"></i> Filtrar
                    </button>

                    <a href="{{ route('users.manage.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-qa="button-reset">
                        <i class="fas fa-redo mr-2"></i> Reiniciar
                    </a>
                </div>
            </form>
        </div>

        <!-- Taula d'usuaris -->
        @php
            $headers = [
                'id' => 'ID',
                'name' => 'NOM',
                'email' => 'EMAIL',
                'role' => 'ROL',
                'created_at' => 'DATA DE CREACIÓ',
            ];

            $formatters = [
                'role' => function($user) {
                    return $user->getRoleNames()->first() ? ucfirst($user->getRoleNames()->first()) : 'Sense rol';
                },
                'created_at' => function($user) {
                    return isset($user->created_at) ? $user->created_at->format('d/m/Y') : 'Sense data';
                },
            ];

            $actions = function($user) {
                return '
                    <div class="flex space-x-2 justify-end">
                        <a href="'.route('users.show', $user->id).'" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-indigo-600 text-white hover:bg-indigo-700" data-qa="view-user-'.$user->id.'">
                            <i class="fas fa-eye mr-1"></i> Veure
                        </a>
                        <a href="'.route('users.manage.edit', $user->id).'" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-yellow-600 text-white hover:bg-yellow-700" data-qa="edit-user-'.$user->id.'">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </a>
                        <form action="'.route('users.manage.destroy', $user->id).'" method="POST" class="inline" data-qa="delete-user-'.$user->id.'">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-red-600 text-white hover:bg-red-700" onclick="return confirm(\'Estàs segur que vols eliminar aquest usuari?\')">
                                <i class="fas fa-trash-alt mr-1"></i> Eliminar
                            </button>
                        </form>
                    </div>
                ';
            };
        @endphp

        <x-responsive-table :headers="$headers" :formatters="$formatters" :data="$users" :actions="$actions" />

        @if($users->isEmpty())
            <div class="mt-6">
                <x-empty-state
                    type="users"
                    message="No hi ha usuaris disponibles. Crea el teu primer usuari!"
                    action="Crear Usuari"
                    actionUrl="{{ route('users.manage.create') }}"
                />
            </div>
        @else
            <!-- Paginació -->
            @if(isset($users) && method_exists($users, 'hasPages') && $users->hasPages())
                <div class="mt-6">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @endif

            <!-- Estadístiques -->
            <div class="mt-6 bg-white rounded-lg shadow-md p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Estadístiques</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-indigo-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">Total d'usuaris</p>
                        <p class="text-2xl font-bold text-indigo-700">{{ $users->total() ?? count($users) }}</p>
                    </div>
                    <div class="bg-indigo-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">Usuaris aquest mes</p>
                        <p class="text-2xl font-bold text-indigo-700">{{ isset($usersThisMonth) ? $usersThisMonth : '0' }}</p>
                    </div>
                    <div class="bg-indigo-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">Usuaris actius</p>
                        <p class="text-2xl font-bold text-indigo-700">{{ isset($activeUsers) ? $activeUsers : '0' }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-videos-app-layout>
