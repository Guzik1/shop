<?php
    include_once('../utils/UserManager.php');
    include_once("../utils/database.php");

    $db = new Baza();

    UserManager::checkLogedUserIsAdmin($db);

    $searchOrderNumber = filter_input(INPUT_GET, "searchOrderNumber", FILTER_SANITIZE_MAGIC_QUOTES);
    $searchUser = filter_input(INPUT_GET, "searchUser", FILTER_SANITIZE_MAGIC_QUOTES);
    $searchEmail = filter_input(INPUT_GET, "searchEmail", FILTER_SANITIZE_MAGIC_QUOTES);
?>

<html lang="pl">
    <head>
        <title>Lista zamówień</title>

        <?php include('../utils/headers.php'); ?>
    </head>
    <body>
        <?php include('./nav.php'); ?>

        <section class=" row justify-content-md-center">
            <div class="col-12 col-md-9 mt-3">
                <div class="row col-12 justify-content-md-center">
                    <form class="form-inline col-md-9 col-12" action="orders.php" method="get">
                        <input class="form-control mr-sm-2 col-md-2 col-12" name="searchOrderNumber" placeholder="numer zamówienia" <?php
                            if(isset($searchOrderNumber))
                                echo "value='$searchOrderNumber'";
                        ?>>
                        <input class="form-control mr-sm-2 col-md-3 col-12" name="searchUser" placeholder="użytkownik" <?php
                            if(isset($searchUser))
                                echo "value='$searchUser'";
                        ?>>
                        <input class="form-control mr-sm-2 col-md-3 col-12" name="searchEmail" placeholder="email" <?php
                            if(isset($searchEmail))
                                echo "value='$searchEmail'";
                        ?>>
                        <button class="btn btn-outline-success my-2 my-sm-0 col-md-2 col-12" type="submit">Wyszukaj</button>
                        <a class="btn btn-outline-danger my-2 my-sm-0 col-md-1 col-12 ml-5" href="orders.php">Wyczyść</a>
                    </form>
                </div>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 6%">Id</th>
                            <th scope="col" style="width: 20%">Data</th>
                            <th scope="col" style="width: 16%">Użytkownik</th>
                            <th scope="col" style="width: 20%">Email</th>
                            <th scope="col" style="width: 45%">Adres</th>
                            <th scope="col" style="width: 20%">Razem</th>
                            <th scope="col" style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT `id`, `userId`, `date`, `totalPrice` FROM `orders`";

                            if($searchOrderNumber != null || $searchUser != null || $searchEmail != null){
                                $sql = $sql . " WHERE ";
                            }

                            if($searchOrderNumber != null ){
                                $sql = $sql . "id =". $searchOrderNumber . " ";
                            }

                            if($searchUser != null ){
                                $sql2 = "SELECT `id` FROM `users` WHERE `userName`='$searchUser'";
                                $userId = $db->select($sql2);

                                if($userId != null){
                                    if($searchOrderNumber != null)
                                        $sql = $sql ."AND ";
    
                                    $sql = $sql . "(userId=". $userId["id"] . " ";

                                    if($searchEmail == null)
                                        $sql = $sql . " )";
                                }
                            }

                            if($searchEmail != null ){
                                $sql2 = "SELECT `id` FROM `users` WHERE `userName`='$searchUser'";
                                $emailData = $db->select($sql2);

                                if($emailData != null){
                                    if($searchUser != null)
                                        $sql = $sql ."OR ";
                                    else{
                                        if($searchOrderNumber != null)
                                            $sql = $sql ."AND (";
                                    }

                                    $sql = $sql . "userId=". $emailData["id"] . ")";
                                }
                            }

                            $sql = $sql . " LIMIT 50";

                            $data = $db->selectFetchAll($sql);

                            for($i = 0; $i < count($data); $i++){
                                $email = "";
                                $addressString = "";
                            
                                $sql = "SELECT `userName`, `email` FROM `users` WHERE `id`=" .  $data[$i]["userId"];
                                $userData = $db->select($sql);

                                $sql = "SELECT `firstName`, `lastName`, `zipcode`, `city`, `address`, `phoneNumber` FROM `addresses` WHERE `id`=" . $data[$i]["id"];
                                $address = $db->select($sql);

                                if($address != null)
                                    $addressString = $address["firstName"] . " " . $address["lastName"] . ", " . $address["address"] . ", " . $address["zipcode"] . " " . $address["city"];

                                echo "<tr><td>" . $data[$i]["id"] . "</td>";
                                echo "<td>" . $data[$i]["date"] . "</td>";
                                echo "<td>" . $userData["userName"] . "</td>";
                                echo "<td>" . $userData["email"] . "</td>";
                                echo "<td>" . $addressString . "</td>";
                                echo "<td>" . $data[$i]["totalPrice"] . "</td>";
                                echo "<td><a type='button' href='./order.php?id=" . $data[$i]["id"] . "' class='btn btn-dark'>Szczegóły</a></td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <?php
            include('../utils/footer.php');
        ?>
    </body>
</html>