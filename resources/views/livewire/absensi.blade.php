<div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                Simpan Absensi
            </button>
        </div>
    </form>
</div>
