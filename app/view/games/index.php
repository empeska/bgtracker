<!DOCTYPE html>
<html>
<head>
    <title>Games</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Games</h1>
    <a href="/" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block">Back to Home</a>
    <a href="/games/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Game</a>
    <table class="w-full bg-white shadow-md rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Name</th>
                <th class="p-2">Default Mode</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($games as $game): ?>
                <tr>
                    <td class="p-2"><?php echo htmlspecialchars($game['name']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($game['defaultMode']); ?></td>
                    <td class="p-2">
                        <form method="POST" action="/games/delete" onsubmit="return confirm('Are you sure you want to delete this game?');">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?php echo $game['ID']; ?>">
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
