<?php
    include_once("./utils/config.php");

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION['cart']))
        header("location: ./cart.php");

    include_once("./utils/CartManager.php");
    include_once("./utils/CartItem.php");
    include_once("./utils/database.php");

    $db = new Baza();

    include_once('./utils/UserManager.php');
    $userId = UserManager::getLoggedInUserId($db);

    $addressId = -1;
    $addressId = filter_input(INPUT_GET, "addressId", FILTER_VALIDATE_INT);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $addressId = filter_input(INPUT_POST, "addressId", FILTER_VALIDATE_INT);

        if($userId == -1)
        header("location: ./index.php");

        if(!isset($_SESSION['cart']))
            header("location: ./index.php");

        $data = filter_input_array(INPUT_POST, $filters);
                            
        $errors = "";
        foreach ($data as $key => $val) {
            if ($val === false or $val === NULL) {
                $errors .= $key . " ";
            }
        }

        if ($errors === "") {
                       $cartObj = unserialize($_SESSION['cart']);
            $cart = $cartObj->getCart();

            $sum = 0.0;
            foreach($cart as $item){
                $sql = "SELECT `price` FROM `items` WHERE `id`=" . $item->getId();
                $data = $db->select($sql);

                $sum += $item->getQuantity() * $data["price"];
            }

            $sql = "INSERT INTO `orders`(`totalPrice`, `userId`, `date`, `addressId`) VALUES ($sum, '$userId', NOW(), '$addressId')";
            $db->insert($sql);
            $orderId = $db->getLastInserterdIndex();

            foreach($cart as $item){
                $itemId = $item->getId();
                $quantity = $item->getQuantity();

                $sql = "INSERT INTO `orderitems`(`orderId`, `itemId`, `quantity`) VALUES ('$orderId', '$itemId', '$quantity')";
                $db->insert($sql);
            }

            unset($_SESSION['cart']);
            header("location: ./index.php");
        }
    }
?>

<html lang="pl">
    <head>
        <title>Składanie zamówienia - <?php echo $shop_name; ?></title>

        <?php include('utils/headers.php'); ?>
    </head>
    <body>
        <?php
            include('utils/nav.php');

            $sum = 0.0;
        ?>

        <section class=" row justify-content-md-center">
            <?php  
                if($userId == -1){
                    echo "Musisz się zalgować by złożyć zamówienie";
                }else{
                    ?>

                    <div class="col-12 col-md-6">
                        <h2 class="text-center">Podsumowanie zamówienia</h2>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="width: 70%">Nazwa</th>
                                    <th scope="col" style="width: 10%">Cena</th>
                                    <th scope="col" style="width: 10%">Ilość</th>
                                    <th scope="col" style="width: 10%">Razem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $cart;

                                    $cartObj = unserialize($_SESSION['cart']);

                                    if (filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "delete"){
                                        $itemId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

                                        $cartObj->removeItem($itemId);

                                        $_SESSION['cart'] = serialize($cartObj);
                                    }
                                    
                                    $cart = $cartObj->getCart();

                                    foreach($cart as $item) {
                                        $sql = "SELECT `name`, `price` FROM `items` WHERE `id`=" . $item->getId();
                                        $data = $db->select($sql);

                                        echo "<tr><td>" . $data["name"] . "</td>";
                                        echo "<td>" . $data["price"] . "</td>";
                                        echo "<td>" . $item->getQuantity() . "</td>";
                                        echo "<td>" . $item->getQuantity() * $data["price"] . "</td>";

                                        $sum += $item->getQuantity() * $data["price"];
                                    }
                                ?>
                            </tbody>
                        </table>
                        <p class="float-right">Razem: <?php echo $sum; ?> PLN</p><br/>

                        <h5 class="text-center">Adres dostawy:</h5>
                        <?php 
                            if(!ISSET($addressId)){
                                ?>
                                    <a class="btn btn-primary btn-dark" href="addresses.php?action=select" role="button">Wybierz adres</a>
                                <?php
                            }else{
                                $sql = "SELECT `userId`, `firstName`, `lastName`, `zipcode`, `city`, `address`, `phoneNumber` FROM `addresses` WHERE `id`=$addressId";
                                $addressData = $db->select($sql);

                                if($addressData["userId"] == $id){
                                    ?>
                                        <p>Imię nazwisko: <?php echo $addressData["firstName"] . " " . $addressData["lastName"]; ?></p>
                                        <p>Miasto: <?php echo $addressData["zipcode"] . " " . $addressData["city"]; ?></p>
                                        <p>Adres: <?php echo $addressData["address"]; ?></p>
                                        <p>Telefon: <?php echo $addressData["phoneNumber"]; ?></p>

                                        <a class="btn btn-primary btn-dark" href="addresses.php?action=select" role="button">Wybierz inny adres</a>
                                    <?php
                                }
                            }
                        ?>

                        <form action="./processOrder.php" method="post">
                            <?php
                                if(ISSET($addressId)){
                                    if($addressId != -1)
                                        echo "<input type='hidden' id='addressId' name='addressId' value='$addressId'>";

                                    ?>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-dark btn-primary col-12 col-md-4 col-xl-3">Zamów</button>
                                        </div>
                                    <?php
                                }
                            ?>
                        </form>
                    </div>
            <?php } ?>
        </section>

        <?php
            include('utils/footer.php');
        ?>
    </body>
</html>