<html lang="pl">
    <head>
        <title>Logowanie</title>
        <?php include 'utils/headers.php'; ?>
    </head>
    <body>
        <section class="row h-100 justify-content-center align-items-center d-flex flex-column">
            <?php
                include_once 'utils/database.php';
                include_once 'utils/User.php';
                include_once 'utils/UserManager.php';
                
                $db = new Baza();
                $um = new UserManager();

                if (filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "logout") {
                    $um->logout($db);

                    if(filter_input(INPUT_GET, "redirect", FILTER_SANITIZE_FULL_SPECIAL_CHARS)){
                        $redirect = $_GET['redirect'];

                        header("location: $redirect");
                    }
                }

                if($um->userLogged($db)){
                    header("location: index.php");
                }

                if (filter_input(INPUT_POST, "submit", FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "Zaloguj") {
                    $userId = $um->login($db);

                    if ($userId > 0) {
                        //echo "<a href='login.php?action=logout' >Wyloguj</a> </p>";

                        header("location: index.php");
                    }
                    else
                    {
                        echo '<h3 class="text-center">Logowanie</h3>';
                        echo '<div class="alert alert-warning" role="alert">Błędna nazwa użytkownika lub hasło</div>';  
                        $um->loginForm();
                        
                    }
                } 
                else
                {
                    echo '<h3 class="text-center">Logowanie</h3>';
                    $um->loginForm();
                }
            ?>
        </section>
    </body>
</html>




