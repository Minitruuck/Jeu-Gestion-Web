<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer son compte</title>
    <link rel="stylesheet" href="../css/signup.css">
    <link href="https://fonts.googleapis.com/css2?family=Special+Gothic+Condensed+One&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">


</head>

<body class ='body'>
    <h1 class = "Titrejeu">HAINERGIE</h1>

<div class ='rectangle2'></div>

    <div class ='rectangle1'>
        <div class="titre"><p>Créer Un Compte</p></div>
        <form action="signup_controller.php" method="post">
            <label>
                    <div class ="TexteEmail">
                        Email * :
                    </div>
                <input type="email" name = "email" id = "email"  placeholder="Email">
            </label>
            <label>
                <div class = "texteddn">
                    Date de Naissance * :
                </div>

                <input type ="date" name = "ddn" id = "ddn">

            </label>
            <label>
                <div class="textemdp">
                Mot de Passe * :
                </div>
                    <input type = "password" name = "mdp" id = "mdp" placeholder="Mot De Passe">
            </label>
            <input type = "submit" name = "s'inscrire" id = "s'inscrire" value = "S'inscrire">
            <label for ="verslogin">
                <br><a href="login.php" class = "verslogin">J'ai déja un compte</a>
            </label>
        </form>
        </div>



    <?php
    if(isset($_GET['erreur'])){
        if($_GET['erreur'] == 'compteexistant'){
            echo "<div class='erreur'>
                        <p>Compte déja existant</p>
              </div>      ";
        }
        if ($_GET['erreur'] == 'champ'){
            echo "<div class = 'erreurchamp'>
                <p>Veuillez remplir tous les champs</p>
                </div>";
        }
    }
    ?>



</body>
</html>
