<x-videos-app-layout>
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">Detalls de l'Usuari</h1>

                    <div class="grid grid-cols-1 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Nom</h3>
                            <p class="text-base font-medium text-gray-900">{{ $user->name }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Correu electrònic</h3>
                            <p class="text-base font-medium text-gray-900">{{ $user->email }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Rol</h3>
                            <p class="text-base font-medium text-gray-900">
                                {{ $user->getRoleNames()->first() ?? 'Sense rol' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5a5aff]">
                            <i class="fas fa-arrow-left mr-2"></i> Tornar a la llista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-videos-app-layout>
