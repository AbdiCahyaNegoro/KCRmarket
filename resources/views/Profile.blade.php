<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-3xl p-6">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <a href="{{ route('index') }}">
                <img src="{{ asset('assets/img/logobrand.png') }}" alt="Logo Brand" class="w-40 md:w-48">
            </a>
        </div>

        <!-- Profile Form -->
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Data Pribadi</h2>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Foto Profil -->
                <div class="flex justify-center">
                    <img src="{{ asset(Auth::user()->folder. '/' .Auth::user()->foto) }}" alt="Foto Profil" class="w-32 h-32 rounded-full border border-gray-300 object-cover">
                </div>

                <!-- Upload Foto -->
                <div>
                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Unggah Foto</label>
                    <input type="file" id="foto" name="foto" class="block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                </div>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name') ?? Auth::user()->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') ?? Auth::user()->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat') ?? Auth::user()->alamat }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggallahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" id="tanggallahir" name="tanggallahir" value="{{ old('tanggallahir') ?? Auth::user()->tanggallahir }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="jeniskelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select id="jeniskelamin" name="jeniskelamin" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="L" {{ (old('jeniskelamin') ?? Auth::user()->jeniskelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ (old('jeniskelamin') ?? Auth::user()->jeniskelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-all duration-200">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
