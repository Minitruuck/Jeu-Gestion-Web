<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer son compte</title>
    <link href="https://fonts.googleapis.com/css2?family=Special+Gothic+Condensed+One&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/ChangePassword.css">
</head>
<body class="body">
  <h1 class = 'Titrejeu'>HAINERGIE</h1>
  <div class ='rectangle2'></div>
    <div class ='rectangle1'>
        <p class="Titre">Changer De Mot De Passe</p>
    <form method="post" action="ChangePasswordController.php">
        <label class="Email">
            Email Du Compte :
            <input type ="email" id = "email" name = "email" class = "email" placeholder="Email">
        </label>
        <label class="Ancienmdp">
            Ancien Mot De Passe :
            <input type ="password" id = "mdp" name = "mdp" class = "ancienmdp" placeholder="Ancien mot de passe">
        </label>
        <label class="Nouveaumdp">
            Nouveau Mot De Passe
            <input type ="password" id = "nvmdp" name = "nvmdp" class = "nvmdp" placeholder="Nouveau mot de passe">
        </label>
        <label>
            <input type="submit" id="changermdp" class = 'Changermdp' name = "changermdp" value="Changer De Mot De Passe">
        </label>
    </form>
        <a href="login.php" class = "retour">Retour</a>

        <?php
        if(isset($_GET['erreur'])){
            if($_GET["erreur"] == "champ"){
            echo "<p class='champ'>Veuillez remplir les champs</p>";
        }
        if($_GET["erreur"] == "emailcorrespondant"){
            echo "<p class='emailcorrespondant'>Pas de compte associé à ce mail</p>";
        }
        if($_GET["erreur"] == "password"){
            echo "<p class='password'>Mot de passe incorrect</p>";
        }}

        ?>
</body>
</html>