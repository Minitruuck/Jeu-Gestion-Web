<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer son compte</title>
    <link href="https://fonts.googleapis.com/css2?family=Special+Gothic+Condensed+One&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class ='body'>
<div class ='rectangle2'></div>
<h1 class = "Titrejeu">HAINERGIE</h1>
    <div class ='rectangle1'>
        <div class="connexion"><p>Se Connecter</p></div>

    <form action="login_controller.php" method="post">



        <label>
            <div class = "Texteemail">
                Email * :
            </div>
                <input type="email" name = "email" id = "email" placeholder="Email" >
        </label>




        <label>
            <div class = "textemdp">
            Mot de Passe * :
            </div>
            <input type = "password" name = "mdp" id = "mdp" placeholder="Mot De Passe">
        </label>



        <input type = "submit" name = "se connecter" id = "se connecter" value = "Se Connecter">

    </form>
        <a href="ChangePassword.php" class="changermdp">Changer de mot de passe</a>
        <a href="signup.php" class = "verssignup">Je n'ai pas de compte </a>




    <?php
    if(isset($_GET['erreur'])){
        if($_GET['erreur'] == 'mdp'){
            echo "<div class='erreurmdp'><p>Mot de passe incorrect</p></div>";
        }
        else if($_GET['erreur'] == 'email'){
            echo "<div class = 'erreuremail'><p>Pas de compte associé à ce mail</p></div>";
        }
        else if($_GET['erreur'] == 'champ'){
            echo "<div class = 'erreurchamp'>
            <p>Veuillez remplir les champs</p>
            </div>
            ";
        }
        }
    if(isset($_GET['value'])){
        if ($_GET['value'] == 'mdpchanged'){
            echo "<p class='changer'>Le mot de passe a bien été changé</p>";

        }
        if ($_GET['value'] == 'comptecreer'){
            echo "<p class='changer'>Le compte a bien été créé</p>";
        }
    }

    ?>
</div>
</body>
</html>

