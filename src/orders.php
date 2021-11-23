<?php
    include_once('./utils/UserManager.php');
    include_once("./utils/database.php");

    $db = new Baza();

    $userId = UserManager::getLoggedInUserId($db);
    if($userId == -1)
        header("location: ./index.php");
?>

<html lang="pl">
    <head>
        <title>Lista zamówień</title>

        <?php include('./utils/headers.php'); ?>
    </head>
    <body>
        <?php include('./utils/nav.php'); ?>

        <section class=" row justify-content-md-center">
            <div class="col-12 col-md-8">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 10%">Id</th>
                            <th scope="col" style="width: 25%">Data</th>
                            <th scope="col" style="width: 40%">Adres</th>
                            <th scope="col" style="width: 20%">Razem</th>
                            <th scope="col" style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT `id`, `date`, `totalPrice` FROM `orders` WHERE `userId`=$userId LIMIT 10";
                            $data = $db->selectFetchAll($sql);

                            for($i = 0; $i < count($data); $i++){
                                $addressString = "";
                            
                                $sql = "SELECT `firstName`, `lastName`, `zipcode`, `city`, `address`, `phoneNumber` FROM `addresses` WHERE `id`=" . $data[$i]["id"];
                                $address = $db->select($sql);

                                if($address != null)
                                    $addressString = $address["firstName"] . " " . $address["lastName"] . ", " . $address["address"] . ", " . $address["zipcode"] . " " . $address["city"];

                                echo "<tr><td>" . $data[$i]["id"] . "</td>";
                                echo "<td>" . $data[$i]["date"] . "</td>";
                                echo "<td>" . $addressString . "</td>";
                                echo "<td>" . $data[$i]["totalPrice"] . "</td>";
                                echo "<td><a type='button' href='./order.php?id=" . $data[$i]["id"] . "' class='btn btn-dark'>Szczegóły</a></td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <?php
            include('./utils/footer.php');
        ?>
    </body>
</html>