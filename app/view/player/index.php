<?php
/**
 * @file
 * @ingroup Player
 * Widok wyświetlania listy graczy.
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Players</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Players</h1>
    <a href="/" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block">Back to Home</a>
    <a href="/player/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Player</a>
    <table class="w-full bg-white shadow-md rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">First Name</th>
                <th class="p-2">Last Name</th>
                <th class="p-2">Nickname</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($players as $player): ?>
                <tr class="border-b text-center">
                    <td class="p-2"><?php echo htmlspecialchars($player->getFirstName()); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($player->getLastName()); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($player->getNickname()); ?></td>
                    <td class="p-2 flex content-center justify-center space-x-2">
                        <form method="POST" action="/player/delete" onsubmit="return confirm('Are you sure you want to delete this player?');">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?php echo $player->getID(); ?>">
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
