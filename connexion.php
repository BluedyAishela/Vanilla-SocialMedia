<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // La fonction que vous souhaitez exécuter
    connexionTraitement();
}

function connexionTraitement() {
    // Code de votre fonction
    echo "Le formulaire a été soumis avec succès !";
    $email = htmlspecialchars($_POST["user_email"]);
    $password = htmlspecialchars($_POST["user_password"]);

    if (empty($email))
    {
        echo "Veuillez rentrer un mail";
        gestionErreur();
    }
    if (empty($password))
    {
        echo "Veuillez rentrer un mot de passe";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
<?php include('public/navbar.php') ?>
<!-- Le reste du contenu -->
<section class="section-accueil">
    <!--  Gestion des différentes erreurs  -->
    <?php
    function gestionErreur() {
        echo '<div class="alert alert-danger">
                <strong>Erreur</strong> Valeur incorrecte
              </div>';

    }
    ?>
    <!--  Formulaire  -->
    <form method="post">
        <!-- Vos champs de formulaire ici -->
        <label for="name">Email</label>
        <input type="email" id="email" name="user_email">

        <label for="password">Password</label>
        <input type="password" id="password" name="user_password">

        <input class="btn btn-primary" type="submit" value="Soumettre">
    </form>
</section>
</body>
</html>