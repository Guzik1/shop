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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if($userId == -1)
        header("location: ./index.php");

        if(!isset($_SESSION['cart']))
            header("location: ./index.php");

        $filters = array(
            'firstName' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'lastName' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'address' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'postalCode' => array( 'filter' => FILTER_VALIDATE_REGEXP,
                                   'options' => array( 'regexp' => '/^[0-9]{2}-[0-9]{3}$/' )),
            'city' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'telephone' => array( 'filter' => FILTER_VALIDATE_REGEXP,
                                  'options' => array( 'regexp' => '/^[0-9]{3}-[0-9]{3}-[0-9]{3}$/' ))
        );

        $data = filter_input_array(INPUT_POST, $filters);
                            
        $errors = "";
        foreach ($data as $key => $val) {
            if ($val === false or $val === NULL) {
                $errors .= $key . " ";
            }
        }

        if ($errors === "") {
            $sql = "INSERT INTO `addresses`(`userId`, `firstName`, `lastName`, `zipcode`, `city`, `address`, `phoneNumber`) " .
            "VALUES ($userId, '" . $data["firstName"] . "','" . $data["lastName"] . "','" . $data["address"] . "','" . $data["postalCode"] . 
            "', '" . $data["city"] . "', '" . $data["telephone"] . "')";

            $db->insert($sql);
            $addressId = $db->getLastInserterdIndex();

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
                            if ($_SERVER['REQUEST_METHOD'] === 'POST')
                                echo $errors;
                        ?>

                        <form action="./processOrder.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstName">Imię</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Imię" require>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastName">Nazwisko</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Nazwisko" require>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Adres</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Adres" require>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3 col-4">
                                    <label for="postalCode">Kod pocztowy</label>
                                    <input type="text" class="form-control" id="postalCode" name="postalCode" pattern="^\d{2}-\d{3}$" placeholder="00-000" require >
                                </div>
                                <div class="form-group col-md-5 col-8">
                                    <label for="city">Miasto</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Miasto" require >
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label for="telephone">Telefon</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="123-456-789" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" require >
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-dark btn-primary col-12 col-md-4 col-xl-3">Zamów</button>
                            </div>
                        </form>
                    </div>
            <?php } ?>
        </section>

        <?php
            include('utils/footer.php');
        ?>
    </body>
</html>