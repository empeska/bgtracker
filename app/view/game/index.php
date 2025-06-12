<?php
/**
 * @file
 * @ingroup Games
 * Widok wyświetlania biblioteki gier
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Games</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6" onload="sortTable(1)">
    <h1 class="text-2xl font-bold mb-4">Games</h1>

    <a href="/" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block">Back to Home</a>
    <a href="/game/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Game</a>

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
                <tr class="border-b text-center">
                    <td class="p-2"><?php echo htmlspecialchars($game->getName()); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($game->getDefaultMode()); ?></td>
                    <td class="p-2 flex content-center justify-center space-x-2">
                        <form method="POST" action="/game/delete" onsubmit="return confirm('Are you sure you want to delete this game?');">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?php echo $game->getID(); ?>">
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                        <form method="GET" action="/game/stats" class="inline-block">
                            <input type="hidden" name="id" value="<?php echo $game->getID(); ?>">
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Stats</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
