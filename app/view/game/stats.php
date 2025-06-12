<!DOCTYPE html>
<html>
<head>
    <title>Games</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
   <script>
   function sortTable(n) {
     var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
     table = document.getElementById("table");
     switching = true;
     // Set the sorting direction to ascending:
     dir = "asc";
     /* Make a loop that will continue until
     no switching has been done: */
     while (switching) {
       // Start by saying: no switching is done:
       switching = false;
       rows = table.rows;
       /* Loop through all table rows (except the
       first, which contains table headers): */
       for (i = 1; i < (rows.length - 1); i++) {
         // Start by saying there should be no switching:
         shouldSwitch = false;
         /* Get the two elements you want to compare,
         one from current row and one from the next: */
         x = rows[i].getElementsByTagName("TD")[n];
         y = rows[i + 1].getElementsByTagName("TD")[n];
         /* Check if the two rows should switch place,
         based on the direction, asc or desc: */
         if (dir == "asc") {
           if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
             // If so, mark as a switch and break the loop:
             shouldSwitch = true;
             break;
           }
         } else if (dir == "desc") {
           if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
             // If so, mark as a switch and break the loop:
             shouldSwitch = true;
             break;
           }
         }
       }
       if (shouldSwitch) {
         /* If a switch has been marked, make the switch
         and mark that a switch has been done: */
         rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
         switching = true;
         // Each time a switch is done, increase this count by 1:
         switchcount ++;
       } else {
         /* If no switching has been done AND the direction is "asc",
         set the direction to "desc" and run the while loop again. */
         if (switchcount == 0 && dir == "asc") {
           dir = "desc";
           switching = true;
         }
       }
     }
   }
   
   </script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Games</h1>

    <a href="/" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block">Back to Home</a>
    <a href="/game" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Library</a>

    <h3 class="w-full bg-gray-300 shadow-md rounded text-xl font-bold text-center p-2"><?php echo $gameName?></h3>
    <div class="w-full bg-white shadow-md rounded">
       <table class="w-full bg-white shadow-md rounded" id="table">
           <thead>
               <tr class="bg-gray-200">
                   <th class="p-2">Name</th>
                   <th class="p-2 cursor-pointer select-none" onclick="sortTable(1)">Times Played</th>
                   <th class="p-2 cursor-pointer select-none" onclick="sortTable(2)">Win-Rate</th>
               </tr>
           </thead>
           <tbody>
               <?php foreach ($stats as $player): ?>
                   <tr class="border-b text-center">
                       <td class="p-2"><?php echo $player['firstName'] . " " . $player['lastName'] . " \"" . $player['nickname'] . "\""; ?></td>
                       <td class="p-2"><?php echo $player['play_count']?></td> 
                       <td class="p-2"><?php echo $player['win_rate']."%"?></td> 
                   </tr>
               <?php endforeach; ?>
           </tbody>
       </table>
    </div>
</body>
</html>
