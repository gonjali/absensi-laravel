<div>
@if (session()->has('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
        {{ session('success') }}
    </div>
@endif

<h1 class="text-2xl font-semibold mb-6 text-gray-800">Form Absensi</h1>

<form wire:submit.prevent="submit">
   <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-medium mb-2">Nama</label>
                    <input type="text" id="nama" wire:model.defer="nama" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                           placeholder="Masukkan nama">
                    @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="jam_kedatangan" class="block text-gray-700 font-medium mb-2">Jam Kedatangan</label>
                    <input type="time" id="jam_kedatangan" wire:model.defer="jam_kedatangan" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('jam_kedatangan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="kehadiran" wire:model.defer="kehadiran" 
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="kehadiran" class="ml-2 text-gray-700">Hadir</label>
                </div>

                <div class="mb-4">
                    <label for="catatan" class="block text-gray-700 font-medium mb-2">Catatan</label>
                    <textarea id="catatan" wire:model.defer="catatan" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                              rows="4" placeholder="Tambahkan catatan"></textarea>
                    @error('catatan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" 
                        class="w-full px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Simpan Absensi
                </button>
</form>
</div>