<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // La fonction que vous souhaitez exécuter
    connexionTraitement();
}
header('Location: ../connexion.php'); die();

function connexionTraitement(): void {
    require_once '../config.php';
    // On récupère les données du formulaire & on met l'email en minuscule
    $email = htmlspecialchars($_POST["user_email"]);
    $password = htmlspecialchars($_POST["user_password"]);

    $email = strtolower($email);

    // Quelques vérifications avant de vérifier les données
    if (empty($email))
    {
        header('Location: ../connexion.php?erreur=email_length'); die();
    }
    if (empty($password))
    {
        header('Location: ../connexion.php?erreur=password_length'); die();
    }

    // Requête permettant de vérifier les données
    $request = $bdd->prepare('SELECT pseudo, email, password, token FROM user WHERE email = ?');
    $request->execute([$email]);
    $data = $request->fetch();
    $row = $request->rowCount();

    if ($row <= 0) {
        header('Location: ../connexion.php?erreur=row'); die();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../connexion.php?erreur=validate_email'); die();
    }
    if (password_verify($password, $data['password'])) {
        $_SESSION['token'] = $data['token'];
        header('Location: ../index.php?connexion=success');
        die();
    }
    // Si toutes les vérifications échoues, renvoyer un message d'erreur
    header('Location: ../connexion.php?erreur=invalide_password');
    die();
}