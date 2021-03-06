<?php
    include_once("./utils/config.php");
    include_once('./utils/UserManager.php');
    include_once("utils/database.php");

    $db = new Baza();
    $userId = UserManager::getLoggedInUserId($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if($userId == -1)
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
            if(filter_input(INPUT_POST, "submit", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "Dodaj Adres"){
                $sql = "INSERT INTO `addresses`(`userId`, `firstName`, `lastName`, `address`, `zipcode`, `city`, `phoneNumber`) " .
                "VALUES ($userId, '" . $data["firstName"] . "','" . $data["lastName"] . "','" . $data["address"] . "','" . $data["postalCode"] . 
                "', '" . $data["city"] . "', '" . $data["telephone"] . "')";

                $db->insert($sql);

                
           }else if(filter_input(INPUT_POST, "submit", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "Edytuj Adres"){
               $addressEditId = filter_input(INPUT_POST, "itemId", FILTER_VALIDATE_INT);

               $sql = "UPDATE `addresses` SET `firstName`='" . $data["firstName"] . "', `lastName`='" . $data["lastName"] . "', `zipcode`='" . $data["postalCode"] . 
               "', `city`='" . $data["city"] . "', `address`='" . $data["address"] . "', `phoneNumber`='" . $data["telephone"] . "' WHERE `id`=$addressEditId";

               $db->update($sql);
           }

            header("location: ./addresses.php");
        }
    }
?>

<html lang="pl">
    <head>
        <title>Dodawanie Adresu - <?php echo $shop_name; ?></title>

        <?php include('utils/headers.php'); ?>
    </head>
    <body>
        <?php
            include('utils/nav.php');

            $data;
            $addressId = -1;

            if (filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "edit") {
                $addressId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    
                $sql = "SELECT `id`, `firstName`, `lastName`, `zipcode`, `city`, `address`, `phoneNumber` FROM `addresses` WHERE `id`=$addressId";
                $data = $db->select($sql);
            }
        ?>

        <section class=" row justify-content-md-center mt-3">
            <div class="col-12 col-md-6">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST')
                        echo $errors;
                ?>

                <form action="./addAddress.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstName">Imi??</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Imi??" require <?php 
                                if($addressId != -1)
                                    echo "value='". $data["firstName"] . "'";
                            ?> />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastName">Nazwisko</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Nazwisko" require <?php 
                                if($addressId != -1)
                                    echo "value='". $data["lastName"] . "'";
                            ?> />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Adres</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Adres" require <?php 
                            if($addressId != -1)
                                echo "value='". $data["address"] . "'";
                        ?> />
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3 col-4">
                            <label for="postalCode">Kod pocztowy</label>
                            <input type="text" class="form-control" id="postalCode" name="postalCode" pattern="^\d{2}-\d{3}$" placeholder="00-000" require <?php 
                                if($addressId != -1)
                                    echo "value='". $data["zipcode"] . "'";
                            ?> />
                        </div>
                        <div class="form-group col-md-5 col-8">
                            <label for="city">Miasto</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Miasto" require <?php 
                                if($addressId != -1)
                                    echo "value='". $data["city"] . "'";
                            ?> />
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label for="telephone">Telefon</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" placeholder="123-456-789" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" require <?php 
                                if($addressId != -1)
                                    echo "value='". $data["phoneNumber"] . "'";
                            ?> />
                        </div>
                    </div>

                    <?php
                        if($id != -1)
                            echo "<input type='hidden' id='itemId' name='itemId' value='$addressId'>";
                    ?>

                    <div class="text-center">
                        <input type="submit" name="submit" class="btn btn-dark btn-primary col-12 col-md-4 col-xl-3" value="<?php 
                            if($addressId != -1)
                                echo "Edytuj Adres";
                            else
                                echo "Dodaj Adres";
                        ?>" >
                    </div>
                </form>

            </div>
        </section>

        <?php
            include('utils/footer.php');
        ?>
    </body>
</html>