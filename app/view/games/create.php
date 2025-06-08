<!DOCTYPE html>
<html>
<head>
    <title>Add Game</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Add Game</h1>
    <div class="bg-white p-6 rounded shadow-md">
        <form method="POST" action="/games/create">
            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="w-full p-2 border rounded"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Default Mode</label>
                <select name="defaultMode" class="w-full p-2 border rounded">
                    <option value="PVP">PVP</option>
                    <option value="Coop">Coop</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</body>
</html>
