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

            $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_MAGIC_QUOTES);

            $sql = "SELECT `id`, `name`, `price` FROM `items` WHERE `visable`=1 AND `name` LIKE '%$search%' LIMIT 10";
            $data = $db->selectFetchAll($sql);

            include('utils/nav.php');

            echo '<div class="row justify-content-md-center">';
            echo '<div class="row col-7">';

            for($i = 0; $i < count($data); $i = $i+3){
                for($j = 0; $j < 3; $j++){
                    if(($i + $j) >= count($data))
                        continue;
                    
                    $dataRow = $data[$i + $j];
                    
                    ?>
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

