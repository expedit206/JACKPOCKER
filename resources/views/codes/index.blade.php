<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-white">
            {{ __('Liste des utilisateurs') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="text-center text-lg font-semibold mb-6 text-black">Liste des utilisateurs inscrits</p>

                    <!-- Tableau des utilisateurs -->
                    <table class="table-auto w-full bg-white rounded-lg shadow-lg">
                        <thead>
                            <tr class="bg-gray-100 text-black">
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Numéro de téléphone</th>
                                <th class="px-4 py-2">Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($utilisateurs as $utilisateur)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">{{ $utilisateur->id }}</td>
                                    <td class="border px-4 py-2">{{ $utilisateur->telephone }}</td>
                                    <td class="border px-4 py-2">{{ $utilisateur->code }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Message en bas de tableau -->
                    <p class="text-center text-black mt-6">Le numéro affiché correspond à celui utilisé pour l'inscription.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
