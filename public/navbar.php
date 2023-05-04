<!-- Barre de navigation -->
<ul>
    <li><a class="active" href="../index.php">Accueil</a></li>
    <?php if (!isset($_SESSION['token'])) { ?>
        <li><a href="../connexion.php">Connexion</a></li>
        <li><a href="../inscription.php">Inscription</a></li>
    <?php } else { ?>
        <li><a href="../src/logout.php">Se déconnecter</a></li>
    <?php } ?>
</ul>