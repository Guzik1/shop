<?php
    include_once("./utils/config.php");
    include_once("./utils/database.php");
    $db = new Baza();

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "clear"){
        unset($_SESSION['cart']);
    }
?>

<html lang="pl">
    <head>
        <title>Koszyk - <?php echo $shop_name; ?></title>
        
        <?php include('utils/headers.php'); ?>
    </head>
    <body>
        <?php
            include('./utils/nav.php');
            include_once("./utils/CartManager.php");
            include_once("./utils/CartItem.php");
            ?>
                <section class=" row justify-content-md-center">
                    <div class="col-12 col-md-6">
                        <?php 
                            if(isset($_SESSION['cart'])){
                                ?>
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col" style="width: 75%">Nazwa</th>
                                            <th scope="col" style="width: 10%">Cena</th>
                                            <th scope="col" style="width: 10%">Ilość</th>
                                            <th scope="col" style="width: 5%"></th>
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

                                            if (filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "removeOne"){
                                                $itemId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

                                                $cartObj->removeOneItem($itemId);

                                                $_SESSION['cart'] = serialize($cartObj);
                                            }

                                            if (filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "addOne"){
                                                $itemId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

                                                $cartObj->addOneItem($itemId);

                                                $_SESSION['cart'] = serialize($cartObj);
                                            }
                                            
                                            $cart = $cartObj->getCart();

                                            foreach($cart as $item) {
                                                $sql = "SELECT `name`, `price` FROM `items` WHERE `id`=" . $item->getId();
                                                $data = $db->select($sql);

                                                echo "<tr><td>" . $data["name"] . "</td>";
                                                echo "<td>" . $data["price"] . "</td>";
                                                echo "<td><a href='./cart.php?action=removeOne&id=" . $item->getId() . "'>-</a> " . $item->getQuantity() . " <a href='./cart.php?action=addOne&id=" . $item->getId() . "'>+</a></td>";
                                                echo "<td><a href='./cart.php?action=delete&id=" . $item->getId() . "'>X</a></td></tr>";
                                            }
                                        ?>
                                    </tbody> 
                                </table>
                            <button onclick="location.href='./cart.php?action=clear'" class="btn bg-dark col-6 col-md-3 text-light">Wyczyść koszyk</button>
                            <button onclick="location.href='./processOrder.php'" class="btn bg-dark col-6 float-right col-md-3 text-light">Zamów</button>
                        <?php
                            }else{
                                echo "Koszyk pusty";
                            }
                       ?>
                    </div>
                </section>
            <?php

        
            include('utils/footer.php');
        ?>
    </body>
</html>

