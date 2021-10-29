<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between justify-content-center">
    <a class="navbar-brand" href="index.php">Sklep</a>

    <?php
        include_once('utils/UserManager.php');
        include_once("utils/database.php");

        $db = new Baza();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $sessionId = session_id();

        $id = UserManager::getLoggedInUser($db, $sessionId);
        $isAdmin = 0;

        if($id != -1){
            $isAdmin = UserManager::userIsAdmin($db, $id);
        }
    ?>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php if($isAdmin){ echo "text-danger"; } ?>" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php 
                        if($id == -1){
                            echo "Twoje konto";
                        }else if($isAdmin == false){
                            echo "Witaj, " . UserManager::getUserName($db, $id);
                        }else{
                            echo "ADMIN " . UserManager::getUserName($db, $id);
                        }
                    ?>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <?php 
                        if($id != -1){
                            $isAdmin = UserManager::userIsAdmin($db, $id);
                            ?>
                                <a class="dropdown-item" href="./orders.php">Zamówienia</a>
                                <a class="dropdown-item" href="./addresses.php">List Adresów</a>

                            <?php if($isAdmin == true){ ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./gzadmin/dashboard.php">Panel admina</a>
                            <?php }; ?>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./login.php?action=logout&redirect=index.php">Wyloguj</a>
                            <?php
                        }else{
                            ?>
                                <a class="dropdown-item" href="./login.php">Zaloguj się</a>
                                <a class="dropdown-item" href="./register.php">Zarejestruj się</a>
                            <?php
                        }
                    ?>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php">Koszyk <?php 
                    if(isset($_SESSION['cart'])){
                        include_once("./utils/CartManager.php");
                        include_once("./utils/CartItem.php");
    
                        $cartObj = unserialize($_SESSION['cart']);
    
                        if($cartObj != null){
                            $cartCount = count($cartObj->getCart());
    
                            if($cartCount > 0)
                                echo "(" . $cartCount . ")";
                        }
                    }
                ?></a>
            </li>
        </ul>
    </div>

    <form class="form-inline my-2 my-lg-0 col-9" action="search.php" method="get">
        <input class="form-control mr-sm-2 col-6" type="search" name="search" placeholder="szukana fraza" <?php
            if(isset($search))
                echo "value='$search'";
        ?>>
        <button class="btn btn-outline-success my-2 my-sm-0 col-1" type="submit">Wyszukaj</button>
    </form>
</nav>