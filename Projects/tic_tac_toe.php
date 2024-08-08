<?php
// Initialize the game board
$board = array_fill(0, 9, '');

// Update the board with user's move
if (isset($_POST['move'])){
    $board[$_POST['move'] - 1] = 'X';
}
?>

<!-- Display the game board -->
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic-tac-toe</title>
    <link rel="stylesheet" href="tic_tac_toe.css">
 </head>
 <body>
    

<div class="grid-container">
    <?php
    for ($i = 0; $i < 9; $i++){?>
        <div class="grid-item">
        <?= $board[$i] !== '' ? $board[$i] : $i + 1 ?>
        </div>
    <?php }?>
</div>
<!-- Form to input moves -->
<form action="" method="POST">
    <label for="move">Enter your move (0-9)</label>
    <input type="number" id="move" name="move" min="1" max="9" required>
    <button type="submit">Make Move</button>
</form>
 </body>
 </html>