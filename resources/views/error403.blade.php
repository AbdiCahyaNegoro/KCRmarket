<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 403 - Forbidden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex flex-col items-center justify-center h-screen">
    <div class="text-center">
        <img src="{{ asset('assets/img/logobrand.png') }}" alt="Logo Brand" class="w-48 mb-6">
        <h1 class="text-6xl font-bold text-red-600 mb-4">ERROR 403</h1>
        <p class="text-lg text-gray-700 mb-6">Anda tidak memiliki akses ke halaman ini.</p>
        <a href="{{ url('/') }}"
            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition">
            Kembali ke Halaman Utama
        </a>
    </div>
</body>

</html>