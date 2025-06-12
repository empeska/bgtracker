<?php
/**
 * @file
 * @ingroup Match
 * Widok dodawający rozgrywkę.
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Record Match</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script>
function addPlayer() {
   const container = document.getElementById('players-container');
   const index = container.children.length;
   const template = document.createElement('div');
   template.className = 'player-entry flex mb-2';
   template.innerHTML = `
      <select name="players[${index}][playerID]" class="w-1/2 p-2 border rounded mr-2" required onchange="updatePlayerOptions()">
                    <option value="" disabled selected>Select your option</option>
                    <?php foreach ($players as $player): ?>
                        <option value="<?php echo $player->getID(); ?>"><?php echo htmlspecialchars($player->getNickname()); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="players[${index}][points]" class="w-1/2 p-2 border rounded" placeholder="Points" required>
                <button type="button" onclick="this.parentElement.remove(); updatePlayerOptions();" class="bg-red-500 text-white px-2 py-1 rounded ml-2">Remove</button>
            `;
   container.appendChild(template);
   updatePlayerOptions();
}

function updatePlayerOptions() {
   const container = document.getElementById('players-container');
   const selects = container.querySelectorAll('select');
   const selectedValues = Array.from(selects).map(s => s.value).filter(v => v);
   selects.forEach((select, index) => {
   const currentValue = select.value;
   select.innerHTML = '<?php foreach ($players as $player): ?><option value="<?php echo $player->getID(); ?>"><?php echo htmlspecialchars($player->getNickname()); ?></option><?php endforeach; ?>';
   select.value = currentValue || '';
   Array.from(select.options).forEach(option => {
   if (option.value && selectedValues.includes(option.value) && option.value !== currentValue) {
      option.disabled = true;
   } else {
      option.disabled = false;
   }
   });
   });
}
function defaultDate() {
   const convertToDateTimeLocalString = (date) => {
      const year = date.getFullYear();
      const month = (date.getMonth() + 1).toString().padStart(2, "0");
      const day = date.getDate().toString().padStart(2, "0");
      const hours = date.getHours().toString().padStart(2, "0");
      const minutes = date.getMinutes().toString().padStart(2, "0");

      return `${year}-${month}-${day}T${hours}:${minutes}`;
   }
   const container = document.getElementById('datepicker');
   const today = new Date();
   container.value = convertToDateTimeLocalString(today);
}
document.addEventListener('DOMContentLoaded', function() {
   defaultDate();
}, false);
    </script>
</head>

<body class="bg-gray-100 p-6" onload="updatePlayerOptions()">
    <h1 class="text-2xl font-bold mb-4">Record Match</h1>
    <?php if (isset($error)): ?>
        <div><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="bg-white p-6 rounded shadow-md">
        <form method="POST" action="/match/create">
            <!-- game selection -->
            <div class="mb-4">
                <label class="block text-gray-700">Game</label>
                <select name="gameID" class="w-full p-2 border rounded" required>
                    <?php foreach ($games as $game): ?>
                        <option value="<?php echo $game->getID(); ?>"><?php echo htmlspecialchars($game->getName()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- game mode selection -->
            <div class="mb-4">
                <label class="block text-gray-700">Game Mode</label>
                <select name="gameMode" class="w-full p-2 border rounded">
                    <option value="PVP">PVP</option>
                    <option value="Coop">Coop</option>
                </select>
            </div>
            <!-- date and time selection -->
            <div class="mb-4">
                <label class="block text-gray-700">Date</label>
                <input id="datepicker" type="datetime-local" name="date" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Duration (HH:MM:SS)</label>
                <input type="time" name="duration" class="w-full p-2 border rounded">
            </div>
            <!-- notes field -->
            <div class="mb-4">
                <label class="block text-gray-700">Notes</label>
                <textarea name="notes" class="w-full p-2 border rounded"></textarea>
            </div>
            <!-- players section -->
            <div class="mb-4">
                <label class="block text-gray-700">Players</label>
                <div id="players-container">
                    <div class="player-entry flex mb-2">
                        <select name="players[0][playerID]" class="w-1/2 p-2 border rounded mr-2" required onchange="updatePlayerOptions()">
                            <?php foreach ($players as $player): ?>
                                <option value="<?php echo $player->getID(); ?>"><?php echo htmlspecialchars($player->getNickname()); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" name="players[0][points]" class="w-1/2 p-2 border rounded" placeholder="Points" required>
                    </div>
                </div>
                <button type="button" onclick="addPlayer()" class="bg-green-500 text-white px-4 py-2 rounded">Add Player</button>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</body>
</html>
