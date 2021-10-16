<?php
    include_once('./utils/UserManager.php');
    include_once("./utils/database.php");

    $db = new Baza();

    $userId = UserManager::getLoggedInUserId($db);
    if($userId == -1)
        header("location: ./index.php");

    $orderId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
?>

<html lang="pl">
    <head>
        <title>Szczegóły zamówienia</title>

        <?php include('./utils/headers.php'); ?>
    </head>
    <body>
        <?php 
            include('./utils/nav.php'); 

            $orderData = $db->select("SELECT `date`, `totalPrice`, `addressId` FROM `orders` WHERE `id`=$orderId");
        ?>

        <section class=" row justify-content-md-center">
            <div class="col-12 col-md-6">
                <h2 clas="text-center">Szczegóły zamówienia</h2>
                <h4 clas="text-center">Przedmioty</h4>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 10%">Id</th>
                            <th scope="col" style="width: 60%">Nazwa</th>
                            <th scope="col" style="width: 15%">Cena</th>
                            <th scope="col" style="width: 15%">Ilość</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT `orderitems`.`itemId`, `orderitems`.`quantity`, `items`.`name`, `items`.`price` FROM `orderitems` INNER JOIN `items` WHERE  `orderitems`.`orderId`=$orderId AND `orderitems`.`itemId`=`items`.`id`";
                            $data = $db->selectFetchAll($sql);
                            
                            for($i = 0; $i < count($data); $i++){
                                echo "<tr><td>" . $data[$i]["itemId"] . "</td>";
                                echo "<td>" . $data[$i]["name"] . "</td>";
                                echo "<td>" . $data[$i]["price"] . "</td>";
                                echo "<td>" . $data[$i]["quantity"] . "</td>";
                            }
                        ?>
                    </tbody>
                </table>
                <div class="col-12">
                    <p class="float-right">Razem <?php echo $orderData["totalPrice"] ?> PLN</p><br/>
                </div>
                <div class="col-12">
                    <h4 class="text-center">Adres dostawy:</h4>
                    <?php 
                        $sql = "SELECT `firstName`, `lastName`, `zipcode`, `city`, `address`, `phoneNumber` FROM `addresses` WHERE `id`=$orderId";
                        $address = $db->select($sql);
                       
                        if($address != null){
                            echo "Imię: " . $address["firstName"] . "<br />";
                            echo "Nazwisko: " . $address["lastName"] . "<br />";
                            echo "Kod pocztowy: " . $address["zipcode"] . "<br />";
                            echo "Miasto: " . $address["city"] . "<br />";
                            echo "Adres: " . $address["address"] . "<br />";
                            echo "Numer telefonu: " . $address["phoneNumber"] . "<br />";
                        }
                    ?>

                </div>
            </div>
        </section>

        <?php
            include('./utils/footer.php');
        ?>
    </body>
</html>