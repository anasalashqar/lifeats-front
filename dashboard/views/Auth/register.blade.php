<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
    <link href="{{ asset('css/Auth.css') }}" rel="stylesheet">

</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-semibold mb-4 text-center">Register</h2>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="w-full p-2 mt-2 border rounded-md" placeholder="Enter your name" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-2 mt-2 border rounded-md" placeholder="Enter your email" required>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-2 mt-2 border rounded-md" placeholder="Enter your password" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-2 mt-2 border rounded-md" placeholder="Confirm your password" required>
                </div>

                <div class="mb-4">
                    <label for="preferences" class="block text-sm font-medium text-gray-700">Preferences/Allergies (Optional)</label>
                    <textarea id="preferences" name="preferences" class="w-full p-2 mt-2 border rounded-md" placeholder="Enter your preferences/allergies"></textarea>
                </div>
                
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md mt-4 hover:bg-blue-600">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
