<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // La fonction que vous souhaitez exécuter
    inscriptionTraitement();
}
// Si la méthode POST n'a pas été trouvée
header('Location: ../inscription.php'); die();

function inscriptionTraitement(): void {
    require '../config.php';

    // On récupère les données envoyées par le formulaire
    $pseudo = htmlspecialchars($_POST['user_pseudo']);
    $email = htmlspecialchars($_POST['user_email']);
    $password = htmlspecialchars($_POST['user_password']);
    $password_retype = htmlspecialchars($_POST['user_password_retype']);

    // On met l'email en minuscule pour éviter les erreurs et doublons
    $email = strtolower($email);

    // On vérifie que tous les champs sont présents & valides
    if (strlen($pseudo) > 30) {
        header('Location: ../inscription.php?erreur=pseudo_length'); die();
    }
    if (strlen($email) > 50) {
        header('Location: ../inscription.php?erreur=email_length'); die();
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../inscription.php?erreur=email_invalide'); die();
    }
    if ($password != $password_retype) {
        header('Location: ../inscription.php?erreur=password_invalide'); die();
    }
    if (checkEmail($email)) {
        header('Location: ../inscription.php?erreur=email_exist'); die();
    }
    if (checkPseudo($pseudo)) {
        header('Location: ../inscription.php?erreur=pseudo_exist'); die();
    }
    // Méthode de hachage du mot de passe
    $cost = ['cost' => 12];
    $password = password_hash($password, PASSWORD_BCRYPT, $cost);

    // Préparation et exécution de la requête
    $request = $bdd->prepare('INSERT INTO user(pseudo, email, password, token) VALUES(:login, :email, :password, :token)');
    $request->execute(array(
        'login' => $pseudo,
        'email' => $email,
        'password' => $password,
        'token' => bin2hex(openssl_random_pseudo_bytes(64)) // Génération d'un token aléatoire -> Solution alternative : uniqid();
    ));
    header('Location: ../inscription.php?erreur=success');
    die();
}

function checkEmail(string $email): bool {
    require '../config.php';

    $request = $bdd->prepare('SELECT email FROM user WHERE email = ?');
    $request->execute([$email]);
    $row = $request->rowCount();
    if ($row > 0) {
        return true;
    }
    return false;
}

function checkPseudo(string $pseudo): bool {
    require '../config.php';

    $request = $bdd->prepare('SELECT pseudo FROM user WHERE pseudo = ?');
    $request->execute([$pseudo]);
    $row = $request->rowCount();
    if ($row > 0) {
        return true;
    }
    return false;
}