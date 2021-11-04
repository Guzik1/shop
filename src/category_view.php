<?php
    include_once("./utils/config.php");
?>

<html lang="pl">
    <head>
        <title>Wyszukiwanie - <?php echo $shop_name; ?></title>
        
        <?php include('utils/headers.php'); ?>
    </head>
    <body>
        <?php
            include_once("./utils/database.php");
            $db = new Baza();

            $cat = $_GET['catId'];

            $sqlCat = "SELECT `id`, `category_name` FROM `categories` WHERE `id`='$cat'";
            $cats = $db->selectFetchAll($sqlCat);

            $sql = "SELECT `id`, `name`, `price` FROM `items` WHERE `visable`=1";
            $data = $db->selectFetchAll($sql);

            include('utils/nav.php');

            $sql3 = 'SELECT `item_categories`.`item_fk`, `items`.`id`, `items`.`name`, `items`.`price` FROM `item_categories` INNER JOIN `items` ON `item_categories`.`item_fk` = `items`.`id` WHERE  `item_categories`.`category_fk`=' .$cats[0]['id'];
            $prods = $db->selectFetchAll($sql3);

            echo "<div style='height:1em' class='jumbotron text-center'> <h3> " .$cats[0]['category_name']. " </h3></div>";
            echo '<div class="row justify-content-md-center">';
            echo '<div class="row col-7">';


            for($i = 0; $i < count($prods); $i = $i+3){
                for($j = 0; $j < 3; $j++){
                    if(($i + $j) >= count($prods))
                        continue;
                    
                    $dataRow = $prods[$i + $j];
                    
                    ?>
                    <script>
                        console.log(<?= json_encode($prods); ?>);
                        console.log(<?= json_encode($data); ?>);
                    </script>
                        <div class="col-xl-4 col-md-6 col-12 p-2">
                            <div class="card">
                                <div class="text-center" style="width:92%; margin: 4%;">
                                    <a href="./item.php?id=<?php echo $dataRow['id']; ?>" class="text-dark">
                                        <img  src="<?php 
                                            if (file_exists("./img/items/" . $dataRow['id'] . ".jpg"))
                                                echo "./img/items/" . $dataRow['id'] . ".jpg";
                                            else
                                                echo "./img/items/noimage.jpg";
                                        ?>" class="rounded text-center" height="160" width="160">
                                </div>
                                <div class="card-body">
                                    <div class="card-text text-left"><b><?php echo $dataRow['name']; ?></b></div>
                                    <div class="card-text text-left"><?php echo $dataRow['price']; ?> PLN</div>
                                </div></a>
                            </div>
                        </div>
                    <?php
                }	
            }
        ?>

        </div></div>
        <?php
            include('utils/footer.php');
        ?>
    </body>
</html>

