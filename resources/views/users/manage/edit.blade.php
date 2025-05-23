<x-videos-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-600">
                <h1 class="text-xl font-bold text-white">✏️ Editar Usuari</h1>
            </div>

            <div class="p-6">
                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p class="font-bold">S'han produït errors:</p>
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.manage.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6">
                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('name', $user->name) }}" required data-qa="input-name">
                        </div>

                        <div class="col-span-1">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('email', $user->email) }}" required data-qa="input-email">
                        </div>

                        <div class="col-span-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Contrasenya (deixa en blanc per no modificar)</label>
                            <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" data-qa="input-password">
                            <p class="mt-1 text-xs text-gray-500">Deixa aquest camp buit si no vols canviar la contrasenya.</p>
                        </div>

                        <div class="col-span-1">
                            <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required data-qa="select-role">
                                <option value="">Selecciona un rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ (old('role', $user->getRoleNames()->first()) == $role) ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('users.manage.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="mr-2">×</span> Cancel·lar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-qa="button-edit-user">
                                <i class="fas fa-save mr-2"></i> Actualitzar Usuari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-videos-app-layout>
