<?php
session_start();
session_destroy();
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer son compte</title>
    <link rel="stylesheet" href="../css/logout.css">
    <link href="https://fonts.googleapis.com/css2?family=Special+Gothic+Condensed+One&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">
</head>
<body class="body">
<h1 class = "Titrejeu">HAINERGIE</h1>

    <div class="rectangle1">
    <form action="login.php" method="post">
        <h1 class="title_disconnected">Vous avez été déconnecté(e)</h1>
        <input class="reconnect_button" type="submit" id = 'se_reconnecter' name = 'se_reconnecter' value = 'Se reconnecter'>
        <?php
if(isset($_GET['value'])) {
    if ($_GET['value'] == 1) {
        echo "<div class='gameover'><p>Game Over ! Recrée-toi un compte pour rejouer </p></div>";
    }
}
?>
    </form>
    </div>
    <div class="rectangle2">

    </div>


</body>
</html>