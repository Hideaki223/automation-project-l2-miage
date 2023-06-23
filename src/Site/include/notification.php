<!-- Partie d'affichage du tableau de navigation, present sur toutes les pages du site -->
<div class="dashboard_notification">
    <h1>Notifications r&eacute;centes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Salle</th>
                <th>Capteur</th>
                <th>Valeur</th>
                <th>Complément</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $resultat = getNotifications($connexion, $nbrNotification);
            while ($m = mysqli_fetch_array($resultat)) {
            ?>
            <tr>
                <td><?php echo $m["IdNotif"] ?></td>
                <td><?php echo $m["TitreNotif"] ?></td>
                <td><?php echo $m["Salle"] ?></td>
                <td><?php echo $m["NomCapteur"] ?></td>
                <td><?php echo $m["Valeur"]." ".$m["unite"] ?></td>
                <td><?php echo $m["ContenuNotif"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
