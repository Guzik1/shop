<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between justify-content-center">
    <a class="navbar-brand" href="index.php">Sklep</a>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Twoje konto
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <?php 
                        //include_once('utils/User.php');
                        include_once('utils/UserManager.php');
                        include_once("utils/database.php");

                        $db = new Baza();

                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        
                        $sessionId = session_id();

                        $id = UserManager::getLoggedInUser($db, $sessionId);
                        if($id != -1){
                            $isAdmin = UserManager::userIsAdmin($db, $id);
                            ?>
                                <a class="dropdown-item" href="./orders.php">Zamówienia</a>
                            
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
                <a class="nav-link" href="cart.php">Koszyk</a>
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