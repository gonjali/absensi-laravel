<div>
   @if (session()->has('success'))
       <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
           {{ session('success') }}
       </div>
    @endif
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Form Piket</h1>
    <form wire:submit.prevent="submit">
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-2">Nama</label>
            <input type="text" id="name" wire:model.defer="name" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                   placeholder="Masukkan nama">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        
       <div class="mb-4">
            <label for="tanggal_waktu_piket" class="block text-gray-700 font-medium mb-2">Tanggal dan Waktu Piket</label>
            <input type="datetime-local" id="tanggal_waktu_piket" wire:model.defer="tanggal_waktu_piket" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('tanggal_waktu_piket') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

       <div class="mb-4 flex items-center">
            <input type="checkbox" id="piket" wire:model.defer="piket" 
                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="piket" class="ml-2 text-gray-700">Tugas Piket Selesai</label>
        </div>

        <div class="mb-4">
            <label for="catatan" class="block text-gray-700 font-medium mb-2">Catatan</label>
            <textarea id="catatan" wire:model.defer="catatan" 
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                      rows="4" placeholder="Tambahkan catatan terkait tugas piket"></textarea>
            @error('catatan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <button type="submit" 
                class="w-full px-4 py-2 bg-blue-600 text-white font-medium
                rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Simpan Piket
        </button>
    </form>
</div>
