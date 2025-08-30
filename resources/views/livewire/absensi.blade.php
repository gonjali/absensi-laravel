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
        <select id="nama" wire:model.defer="nama" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="" disabled>Pilih Nama</option>
            @foreach ($metadatas as $metadata)
                <option value="{{ $metadata->nama }}">{{ $metadata->nama }}</option>
            @endforeach
        </select>
        @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="jam_kedatangan" class="block text-gray-700 font-medium mb-2">Jam Kedatangan</label>
        <input type="time" id="jam_kedatangan" wire:model.defer="jam_kedatangan" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        <p class="text-sm text-gray-500 mt-1">Jam otomatis terset sesuai waktu saat ini</p>
        @error('jam_kedatangan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Status Kehadiran</label>
        <div class="space-y-2">
            <div class="flex items-center">
                <input type="radio" id="status_hadir" name="status_kehadiran" value="hadir" 
                       wire:model.defer="status_kehadiran" 
                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <label for="status_hadir" class="ml-2 text-gray-700">✅ Hadir</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="status_izin" name="status_kehadiran" value="izin" 
                       wire:model.defer="status_kehadiran" 
                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <label for="status_izin" class="ml-2 text-gray-700">🟡 Izin</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="status_tidak_hadir" name="status_kehadiran" value="tidak_hadir" 
                       wire:model.defer="status_kehadiran" 
                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <label for="status_tidak_hadir" class="ml-2 text-gray-700">❌ Tidak Hadir</label>
            </div>
        </div>
        @error('status_kehadiran') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4 flex items-center">
        <span class="text-gray-500 text-sm">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </span>
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
