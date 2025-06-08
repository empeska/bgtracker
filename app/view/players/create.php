<!DOCTYPE html>
<html>
<head>
    <title>Add Player</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Add Player</h1>
    <div class="bg-white p-6 rounded shadow-md">
        <form method="POST" action="/players/create">
            <div class="mb-4">
                <label class="block text-gray-700">First Name</label>
                <input type="text" name="firstName" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Last Name</label>
                <input type="text" name="lastName" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Nickname</label>
                <input type="text" name="nickname" class="w-full p-2 border rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</body>
</html>
