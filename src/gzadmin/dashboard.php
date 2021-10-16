<?php
    include_once('../utils/UserManager.php');
    include_once("../utils/database.php");

    $db = new Baza();

    UserManager::checkLogedUserIsAdmin($db);
?>

<html lang="pl">
    <head>
        <title>Dashboard - sklep</title>

        <?php include('../utils/headers.php'); ?>
    </head>
    <body>
        <?php include('./nav.php'); ?>

<?php /*
        <a type="button" href="./items.php" class="btn btn-dark">Lista przedmiotów</a>
        <a type="button" href="../index.php" class="btn btn-dark">Powrót do strony głownej</a>
*/ ?>






        <?php
            include('../utils/footer.php');
        ?>
    </body>
</html>