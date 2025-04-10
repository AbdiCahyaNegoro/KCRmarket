<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <a href="{{ route('index') }}">
                <img src="{{ asset('assets/img/logobrand.png') }}" alt="Logo Brand" class="w-48">
            </a>
        </div>

        <!-- Profile Form -->
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Data Pribadi</h2>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Foto Profil -->
                <div class="text-center">
                    <img src="{{ asset(Auth::user()->folder. '/' .Auth::user()->foto) }}" alt="Foto Profil" class="w-32 h-32 rounded-full mx-auto border border-gray-300">
                </div>

                <!-- Upload Foto -->
                <div>
                    <label for="foto" class="block text-gray-600">Unggah Foto</label>
                    <input type="file" id="foto" name="foto" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-gray-600">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name') ?? Auth::user()->name }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-600">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') ?? Auth::user()->email }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-gray-600">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat') ?? Auth::user()->alamat }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggallahir" class="block text-gray-600">Tanggal Lahir</label>
                    <input type="date" id="tanggallahir" name="tanggallahir" value="{{ old('tanggallahir') ?? Auth::user()->tanggallahir }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="jeniskelamin" class="block text-gray-600">Jenis Kelamin</label>
                    <select id="jeniskelamin" name="jeniskelamin" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                        <option value="L" {{ (old('jeniskelamin') ?? Auth::user()->jeniskelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ (old('jeniskelamin') ?? Auth::user()->jeniskelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>