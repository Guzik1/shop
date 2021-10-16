<?php
    include_once('../utils/UserManager.php');
    include_once("../utils/database.php");

    $db = new Baza();

    UserManager::checkLogedUserIsAdmin($db);
?>

<html lang="pl">
    <head>
        <title>Lista przedmiotów - sklep</title>

        <?php include('../utils/headers.php'); ?>
    </head>
    <body>
        <?php include('./nav.php'); ?>

        <section class="row justify-content-md-center">
            <table class="table col-12 col-md-9">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width: 3%">Id</th>
                        <th scope="col" style="width: 71%">Nazwa</th>
                        <th scope="col" style="width: 8%">Cena</th>
                        <th scope="col" style="width: 6%">Widoczne</th>
                        <th scope="col" style="width: 6%"></th>
                        <th scope="col" style="width: 6%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                        $sql = "SELECT `id`, `name`, `price`, `visable` FROM `items` LIMIT 25";
                        $result = $db->selectRaw($sql);

                        while($row = mysqli_fetch_array($result)){
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $row["id"] ?></th>
                                    <td><?php echo $row["name"] ?></td>
                                    <td><?php echo $row["price"] ?></td>
                                    <td>
                                        <?php 
                                            if($row["visable"])
                                                echo "tak";
                                            else
                                                echo "nie";
                                        ?>
                                    </td>
                                    <td>
                                        <a type="button" href='./item.php?action=edit&id=<?php echo $row["id"] ?>' class="btn btn-dark">Edycja</a>
                                    </td>
                                    <td>
                                        <a type="button" href='./item.php?action=delete&id=<?php echo $row["id"] ?>' class="btn btn-dark">Usuń</a>
                                    </td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </section>    
        
        <?php
            include('../utils/footer.php');
        ?>
    </body>
</html>