<html lang="pl">
    <head>
        <title>Rejestracja</title>
        
        <?php include('utils/headers.php'); ?>
    </head>
    <body>
        <section class="row h-100 justify-content-center align-items-center d-flex flex-column">
            <h3 class="text-center">Rejestracja</h3>

            <?php
                include_once('utils/User.php');
                include_once('utils/RegistrationForm.php');
                include_once "utils/database.php";
                $db = new Baza();
                $rf = new RegistrationForm();

                if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "Zarejestruj") {
                    echo '<div class="alert alert-warning" role="alert">';
                        $user = $rf->checkUser();
                    echo '</div>';

                    if($user !== NULL){
                        $user->saveToDB($db);
                        
                        header("location: index.php");
                    }
                }

                echo $rf->generateForm();
            ?>
        </section>
    </body>
</html>





