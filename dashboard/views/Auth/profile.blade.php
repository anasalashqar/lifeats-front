<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    @vite('resources/css/app.css')
    <link href="{{ asset('css/Auth.css') }}" rel="stylesheet">

</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-semibold mb-4 text-center">User Profile</h2>
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="w-full p-2 mt-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="w-full p-2 mt-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="preferences" class="block text-sm font-medium text-gray-700">Preferences/Allergies</label>
                    <textarea id="preferences" name="preferences" class="w-full p-2 mt-2 border rounded-md">{{ auth()->user()->preferences }}</textarea>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md mt-4 hover:bg-blue-600">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>
