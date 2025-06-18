<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Absensi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
</body>
</html>
