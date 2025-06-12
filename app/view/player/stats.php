<!DOCTYPE html>
<html>
<head>
    <title>Player Stats</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Stats: <?php echo "{$player['firstName']} {$player['lastName']} \"{$player['nickname']}\""; ?></h1>
    <a href="/player" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block">Back</a>

    <div class="bg-white shadow rounded p-4 mb-6">
        <h2 class="text-xl font-bold mb-2">Global Winrate</h2>
        <p>Matches Played: <?php echo $globalWinrate['total']; ?></p>
        <p>Wins: <?php echo $globalWinrate['wins']; ?></p>
        <p>Winrate: <?php echo $globalWinrate['winrate']; ?>%</p>
    </div>

    <div class="bg-white shadow rounded p-4 mb-6">
        <h2 class="text-xl font-bold mb-2">Most Played Games</h2>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Game</th>
                    <th class="p-2">Times Played</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mostPlayed as $row): ?>
                    <tr class="border-b text-center">
                        <td class="p-2"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td class="p-2"><?php echo $row['games_played']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="bg-white shadow rounded p-4">
        <h2 class="text-xl font-bold mb-2">Best Winrate Games</h2>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Game</th>
                    <th class="p-2">Games Played</th>
                    <th class="p-2">Wins</th>
                    <th class="p-2">Winrate</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mostWon as $row): ?>
                    <tr class="border-b text-center">
                        <td class="p-2"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td class="p-2"><?php echo $row['total_games']; ?></td>
                        <td class="p-2"><?php echo $row['wins']; ?></td>
                        <td class="p-2"><?php echo round($row['win_percentage'], 2); ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

