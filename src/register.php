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
                $user = NULL;
                    try{
                         $user = $rf->checkUser();
                    } catch (Exception $e) {
                        echo '<div class="alert alert-warning" role="alert">Hasło musi zawierać minimum 8 znaków</div>';
                    }
                    if($user !== NULL){
                        try{
                            $user->saveToDB($db);
                            ?>
                                <script>
                                window.location.href = window.location.pathname.substring( 0, window.location.pathname.lastIndexOf( '/' ) + 1 ) + 'login.php'
                                alert("Rejestracja przebiegła poprawnie. Możesz się zalogować.");
                                </script>
                            <?php
                        } catch (Exception $e) {
                            ?>
                                <script>
                                alert("Użytkownik o takim samym adresie email bądź loginie już istnieje. Spróbuj jeszcze raz.");
                                </script>
                            <?php
                        }


                    }
                }

                echo $rf->generateForm();
            ?>
        </section>
    </body>
</html>





