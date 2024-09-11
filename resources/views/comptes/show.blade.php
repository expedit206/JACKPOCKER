<!-- resources/views/packs/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between font-semibold text-xl text-green-300 leading-tight">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ __('Détails du Pack') }}
            </h2>
          
        </div>
    </x-slot>
         <!-- Affichage des messages de session -->
         @if(session('success'))
         <div class="mb-4 p-4 bg-green-300 text-green-700 rounded-md">
             {{ session('success') }}
         </div>
     @elseif(session('error'))
         <div class="mb-4 p-4 bg-red-400 text-white rounded-md">
             {{ session('error') }}
         </div>
     @endif
@if ($compte)
    
    <div class="py-12 bg-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="bg-gray-700 p-6 rounded-lg shadow-md">
                        <h2 class="text-3xl font-bold text-gray-100 mb-4">{{ $pack->name }}</h2>
                        <p class="text-gray-300 mb-2">Montant: {{ $pack->montant }} FCFA</p>
                        <p class="text-gray-300 mb-4">Gain: {{ $pack->montant * 0.15 }} FCFA/jour</p>
                        <p class="text-gray-300 mb-4">Solde actuel: {{ $compte->solde_actuel }} FCFA</p>
                    </div>
<div class="mt-6 mb-3">Effectuer un retrait</div>
                      <!-- Formulaire de retrait -->
                      <form action="{{ route('retrait.store', ['userId' => $compte->user_id, 'compteId' => $compte->id]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="montant" class="block text-sm font-medium text-gray-400">Montant du retrait en FCFA(Minimum 4000FCFA)</label>
                            <input type="number" id="montant" name="montant" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 text-black" min="4000" placeholder="50000 " required>
                        </div>
                  
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Effectuer le retrait
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <p class="bg-red-500 py-3 text-white font-bold text-2xl">Veuillez souscrire a un pack pour voir vos revenu a ce Pack</p>
    @endif

</x-app-layout>
