<div class="flex justify-between mb-2 px-1 text-md mt-4">
    <a href="{{ route('withdraw.form') }}"
        class="bg-gray-700 text-white rounded-lg px-8 py-2 font-bold hover:bg-green-600 transition flex items-center">
        <i class="fas fa-plus-circle mr-2"></i> Dépôt
    </a>
    <a href="{{ route('deposit.form') }}"
        class="bg-gray-700 text-white rounded-lg px-8 py-2 font-bold hover:bg-red-600 transition flex items-center">
        <i class="fas fa-minus-circle mr-2"></i> Retrait
    </a>
</div>