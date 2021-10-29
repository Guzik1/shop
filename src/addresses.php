<?php
    include_once("./utils/config.php");

    $selectAction = false;
    if (filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "select") {
        $selectAction = true;
    }
?>

<html lang="pl">
    <head>
        <title>Lista Adresów - <?php echo $shop_name; ?></title>

        <?php include('utils/headers.php'); ?>
    </head>
    <body>
        <?php
            include('utils/nav.php');

            include_once("utils/database.php");
            $db = new Baza();
        
            $sql = "SELECT `id`, `firstName`, `lastName`, `zipcode`, `city`, `address`, `phoneNumber`, `nip` FROM `addresses` WHERE `userId`=$id";
        
            $addresses = $db->selectFetchAll($sql);
        ?>
            <section class=" row justify-content-md-center mt-3">
                <div class="col-12 col-md-6">
                   
                <div class="row col-12 justify-content-md-center">
                    <div class="col-12 col-md-8">
                        <h1 class="text-center ">Lista Adresów<h1>
                    </div>
                    <div class="col-12 col-md-4 text-right">
                        <a class="btn btn-outline-success" href="addAddress.php">Dodaj adres</a>
                    </div>
                </div>
                <div class="row col-12">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Imię</th>
                                <th scope="col">Nazwisko</th>
                                <th scope="col">Miasto</th>
                                <th scope="col">Adres</th>
                                <th scope="col">Numer Telefonu</th>
                                <th scope="col"><?php 
                                    if($selectAction){
                                        echo "Wybierz";
                                    }else{
                                        echo "Edit";
                                    }
                                ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            for($i = 0; $i < count($addresses); $i = $i+1){
                                $addresse = $addresses[$i];
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $addresse['firstName']; ?></th>
                                    <td><?php echo $addresse['lastName']; ?></td>
                                    <td><?php echo $addresse['zipcode'] . " " . $addresse['city']; ?></td>
                                    <td><?php echo $addresse['address']; ?></td>
                                    <td><?php echo $addresse['phoneNumber']; ?></td>
                                    <td><a class="btn btn-primary btn-sm btn-dark" href="<?php 
                                        if($selectAction){
                                            echo "processOrder.php?addressId=" . $addresse['id'];
                                        }else{
                                            echo "addAddress.php?action=edit&id=" . $addresse['id'];
                                        }
                                    ?>" role="button">
                                        <?php
                                            if($selectAction){
                                                echo "W";
                                            }else{
                                                echo "E";
                                            }
                                        ?>
                                    </a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table> 
                </div>


                </div>
            </section>
        <?php
            include('utils/footer.php');
        ?>
    </body>
</html>