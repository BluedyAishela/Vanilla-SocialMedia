<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // La fonction que vous souhaitez exécuter
    connexionTraitement();
}

function connexionTraitement() {
    $email = htmlspecialchars($_POST["user_email"]);
    $password = htmlspecialchars($_POST["user_password"]);

    $email = strtolower($email);

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