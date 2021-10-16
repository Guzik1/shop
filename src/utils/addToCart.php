<?php
    $itemId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    if($itemId < 0)
        header("location: index.php");

    if (filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "addToCart"){
        include_once("./CartManager.php");

        session_start();

        $cart;
        if(!isset($_SESSION['cart'])){
            $cart = new CartManager();
            $cart->addOneItem($itemId);

            $_SESSION['cart'] = serialize($cart);
        }else{
            include_once("./CartItem.php");

            $cart = unserialize($_SESSION['cart']);
            $cart->addOneItem($itemId);

            $_SESSION['cart'] = serialize($cart);
        }
    }

    header("location: ../item.php?id=$itemId");
?>