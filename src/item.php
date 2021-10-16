<?php
    $itemId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    if($itemId < 0)
        header("location: index.php");

    include_once("./utils/config.php");
    include_once("utils/database.php");

    $db = new Baza();

    $sql = "SELECT `name`, `description`, `price`, `visable` FROM `items` WHERE `id`=$itemId";
    $dane = $db->select($sql);

    if($dane["visable"] == 0)
        header("location: index.php");
?>

<html lang="pl">
    <head>
        <title><?php echo $dane["name"] . " - " . $shop_name; ?></title>
        
        <?php include('utils/headers.php'); ?>
    </head>
    <body>
        <?php
            include('utils/nav.php');
        ?>

        <section class=" row justify-content-md-center">
            <div class="col-12 col-md-6">
                <div class="col-12">
                    <h1 class="display-4">
                        <?php echo $dane["name"]; ?>
                    </h1>
                </div>
                <div class="col-12 d-flex flex-row">
                    <div class="col-9 p-2">
                        <img src="<?php 
                            if (file_exists("./img/items/" . $itemId . ".jpg"))
                                echo "./img/items/$itemId.jpg";
                            else
                                echo "./img/items/noimage.jpg";
                        ?>" class="rounded float-left" height="300" width="300">
                    </div>
                    <div class="col-3 p-2">
                        <p>Cena: <?php echo $dane["price"]; ?> PLN</p>
                        <button onclick="location.href='./utils/addToCart.php?action=addToCart&id=<?php echo $itemId; ?>'" class="btn bg-dark col-12 text-light">Dodaj do koszyka</button>
                    </div>
                </div>
                <div class="col-12">
                    <p>Opis:</p>
                    <?php echo $dane["description"]; ?>
                </div>
            </div>
        </section>

        <?php
            include('utils/footer.php');
        ?>
    </body>
</html>

