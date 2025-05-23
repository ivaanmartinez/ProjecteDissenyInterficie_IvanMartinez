<x-videos-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">👥 Llista d'Usuaris</h1>

        <!-- Search Bar -->
        <div class="max-w-md mx-auto mb-8">
            <form action="{{ route('users.index') }}" method="GET">
                <div class="flex rounded-md shadow-sm">
                    <input type="text" name="search" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Cerca usuaris..." value="{{ request('search') }}">
                    <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-r-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        <i class="fas fa-search mr-2"></i> Cercar
                    </button>
                </div>
                @if(request('search'))
                    <div class="mt-2 text-right">
                        <a href="{{ route('users.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                            <i class="fas fa-times mr-1"></i> Netejar cerca
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Users Grid -->
        @if($users->isEmpty())
            <x-empty-state type="users" message="{{ request('search') ? 'No s\'han trobat usuaris amb aquesta cerca.' : 'No hi ha usuaris disponibles.' }}" />
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($users as $user)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-xl text-indigo-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="text-sm text-gray-500 mb-1">Rol:</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($user->getRoleNames() as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ ucfirst($role) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-calendar-alt mr-1"></i> {{ $user->created_at->format('d/m/Y') }}
                                </span>
                                <a href="{{ route('users.show', $user->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                    <i class="fas fa-eye mr-1"></i> Veure
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(isset($users) && method_exists($users, 'hasPages') && $users->hasPages())
                <div class="mt-8">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </div>
</x-videos-app-layout>
