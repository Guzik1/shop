<?php
    include_once('../utils/UserManager.php');
    include_once("../utils/database.php");

    $db = new Baza();

    UserManager::checkLogedUserIsAdmin($db);

    $id = -1;
    $data;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "delete") {
            $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    
            $sql = "DELETE FROM `items` WHERE id=$id";
            $db->delete($sql);
    
            header("location: ./items.php");
        }
    
        if (filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "edit") {
            $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

            $sql = "SELECT `name`, `description`, `price`, `visable` FROM `items` WHERE `id`={$id}";
            $data = $db->select($sql);
        }
    }
?>

<html lang="pl">
    <head>
        <title>Edycja przedmiotu - sklep</title>

        <?php include('../utils/headers.php'); ?>
    </head>
    <body>
        <?php include('./nav.php'); ?>
            <section class="row h-100 justify-content-center align-items-center d-flex flex-column">

            <form class="col-12 col-md-10 col-xl-6" action="item.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="title" class="col-2 col-form-label">Tytuł:</label>
                    <input class="form-control col-10" type="text" id="title" name="title" maxlength="50" <?php 
                        if($id != -1)
                            echo "value='". $data["name"] . "'";
                    ?> />
                </div>

                <div class="form-group row">
                    <label for="description" class="col-2 col-form-label">Opis:</label>
                    <textarea  class="form-control col-10" id="description" name="description" rows="10" cols="50" maxlength="1000"><?php 
                        if($id != -1)
                            echo $data["description"];
                        ?></textarea>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-2 col-form-label">Cena:</label>
                    <input  class="form-control col-10" id="price" name="price" type="number" min="-2" step="0.01" <?php 
                        if($id != -1)
                            echo "value='". $data["price"] . "'";
                        else
                            echo "value='1.01'";
                    ?> />
                </div>

                <div class="form-group row">
                    <label for="image" class="col-2 col-form-label">Miniatura:</label>
                    <input class="form-control col-10 form-control-file" id="image" name="imageIcon" type="file"></input>
                </div>

                <div class="form-group row">
                    <label for="visable" class="col-2 col-form-label">Widoczność:</label>
                    <input class="form-check-input form-control" type="checkbox" value="" name="visable" id="visable" <?php 
                        if($id != -1){
                            if($data["visable"])
                                echo "checked";
                        }else
                            echo "checked";
                    ?>>
                </div>

                <?php
                    if($id != -1)
                        echo "<input type='hidden' id='itemId' name='itemId' value='$id'>";
                ?>

                <div class="col-12 text-center"> 
                    <input type="submit" name="submit" class="btn btn-dark btn-primary col-5" value="<?php 
                        if($id != -1)
                            echo "Edytuj";
                        else
                            echo "Dodaj przedmiot";
                    ?>" />
                </div>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $filters = array(
                        'price' => FILTER_VALIDATE_FLOAT,
                        'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                        'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
                    );

                    $visable = false;
                    if(isset($_POST['visable']))
                        $visable = true;
                    
                    $data = filter_input_array(INPUT_POST, $filters);
                    
                    $errors = "";
                    foreach ($data as $key => $val) {
                        if ($val === false or $val === NULL) {
                            $errors .= $key . " ";
                        }
                    }
                    
                    if ($errors === "") {
                        if(filter_input(INPUT_POST, "submit", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "Dodaj przedmiot"){
                            $sql = "INSERT INTO `items`(`name`, `description`, `price`, `visable`) VALUES
                            ('" . $data["title"] . "', '" . $data["description"] . "', '" . $data["price"] . "',  $visable)";

                            $db->insert($sql);

                            //$id = $db->getLastInserterdIndex();
                        }else if(filter_input(INPUT_POST, "submit", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "Edytuj"){
                            $itemId = filter_input(INPUT_POST, "itemId", FILTER_VALIDATE_INT);
                            
                            $sql = "UPDATE `items` SET `name`='" . $data["title"] . "',`description`='" . $data["description"] . "',`price`='" . $data["price"] . "', `visable`=" . (int)$visable . " WHERE `id`=$itemId";
                            $db->update($sql);
                        }
                        
                        header("location: ./items.php");
                    } 
                    else
                    {
                        echo '<div class="alert alert-warning" role="alert">Nie poprawnie dane: ' . $errors . '</div>';
                    }
                }
            ?>
        </section>

        <?php
            include('../utils/footer.php');
        ?>
    </body>
</html>