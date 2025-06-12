<?php
/**
 * @file
 * @ingroup Match
 * Widok wyświetlający przebyte rozgrywki.
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Matches</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
   <script>
   function toggleNotes(button) {
       const row = button.closest('tr').nextElementSibling;
       const isVisible = !row.classList.contains('hidden');
       row.classList.toggle('hidden');
       button.textContent = isVisible ? 'Show Notes' : 'Hide Notes';
   }
   </script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Matches</h1>
    <a href="/" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block">Back to Home</a>
    <a href="/match/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Record Match</a>
    <table class="w-full bg-white shadow-md rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Game</th>
                <th class="p-2">Mode</th>
                <th class="p-2">Date</th>
                <th class="p-2">Players</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matches as $match): ?>
                <tr class="text-center" >
                    <td class="p-2"><?php echo htmlspecialchars($match->getGameName()); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($match->getGameMode()); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($match->getDate()); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($match->getPlayers());?></td>
                    <td class="p-2 flex content-center justify-center space-x-2">
                        <button onclick="toggleNotes(this)" class="bg-yellow-500 text-white px-2 py-1 rounded">Show Notes</button>
                        <form method="POST" action="/match/delete" onsubmit="return confirm('Are you sure you want to delete this match?');">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?php echo $match->getID(); ?>">
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
               <tr class="hidden note-row bg-yellow-100">
                    <td colspan="5" class="p-4 text-left text-sm text-gray-700 border-t">
                        <?php echo nl2br(htmlspecialchars($match->getNotes())); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
