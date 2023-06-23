<!-- Barre de navigation de la page du site -->
<aside>
    <div class="sidebar">
        <div class="logo">
            <img src="image/logoCineHome.png" alt="logo">
        </div>
        <!-- Le code php permet de determiner la page sur laquelle on se situe, et d'utiliser le style approprié -->
        <a <?php if ($titre === 'Accueil') {echo 'class="active"';} else { echo 'class="inactive"'; }?> href="accueil.php">
            <img src="image/inactive/accueil.svg" alt="Accueil">
            <h3>Accueil</h3>
        </a>
        <a <?php if ($titre === 'Salle 1') {echo 'class="active"';} else { echo 'class="inactive"'; }?> href="salle1.php">
            <img src="image/inactive/monitor.svg" alt="Salles">
            <h3>Salle 1</h3>
        </a>
        <a <?php if ($titre === 'Salle 2') {echo 'class="active"';} else { echo 'class="inactive"'; }?> href="salle2.php">
            <img src="image/inactive/monitor.svg" alt="Salles">
            <h3>Salle 2</h3>
        </a>
        <a <?php if ($titre === 'Salle 3') {echo 'class="active"';} else { echo 'class="inactive"'; }?> href="salle3.php">
            <img src="image/inactive/monitor.svg" alt="Salles">
            <h3>Salle 3</h3>
        </a>
        <a <?php if ($titre === 'Notification') {echo 'class="active"';} else { echo 'class="inactive"'; }?> href="notification.php">
            <img src="image/inactive/notification-bing.svg" alt="Notifications">
            <h3>Notification</h3>
        </a>
        <a <?php if ($titre === 'Parametres') {echo 'class="active"';} else { echo 'class="inactive"'; }?> href="#">
            <img src="image/inactive/setting-2.svg" alt="Parametres">
            <h3>Parametres</h3>
        </a>
        <a <?php if ($titre === 'Deconnexion') {echo 'class="active"';} else { echo 'class="inactive"'; }?> href="login.php" >
            <img src="image/inactive/logout.svg" alt="Deconnexion">
            <h3>Deconnexion</h3>
        </a>
    </div>
</aside>