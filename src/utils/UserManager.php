<?php
class UserManager {
    function loginForm() {
    ?>
        <form class="col-12 col-md-6 col-xl-3" action="login.php" method="post">
            <div class="form-group">
                <label for="login">Login:</label>
                <input class="form-control col-12" id="login" name="login" type="text" maxlength="25" />
            </div>

            <div class="form-group">
                <label for="passwd">Hasło:</label>
                <input class="form-control col-12" id="passwd" name="passwd" type="password" maxlength="25" />
            </div>

            <div class="col-12 text-center"> 
                <input type="submit" name="submit" class="btn btn-dark btn-primary col-8" value="Zaloguj" />
            </div>
        </form>
    <?php
    }

    function login($db) {
        include "config.php";

        $args = [
            'login' => FILTER_SANITIZE_ADD_SLASHES,
            'passwd' => FILTER_SANITIZE_ADD_SLASHES
        ];

        $dane = filter_input_array(INPUT_POST, $args);
 
        $login = $dane["login"];
        $passwd = hash_hmac('sha256', $dane["passwd"] , $hash_key);
        $userId = $db->selectUser($login, $passwd, "users");

        if ($userId >= 0) {
            session_start();

            $sql = "DELETE FROM logged_in_users WHERE userId=" . $userId;
            $test = $db->delete($sql);
            if($test){
                echo 'Succes deleted';
            }else{
                echo $sql;
            }
            $date = date("Y-m-d H:i:s");

            $sessionId = session_id();

            $sql = "INSERT INTO `logged_in_users`(`sessionId`, `userId`, `lastUpdate`) VALUES ('" . $sessionId . "',
                 " . $userId . ", '" . $date . "')";
            $db->insert($sql);
        }

        return $userId;
    }

    function logout($db) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $sessionId = session_id();

        session_unset();
        session_destroy();
        
        if (isset($_COOKIE[session_name()])) 
            setcookie(session_name(), "", time() - 3600);

        $sql = "DELETE FROM logged_in_users WHERE sessionId='" . $sessionId . "'";
        $db->delete($sql);
    }

    static function getLoggedInUser($db, $sessionId) {
        $id = -1;

        $sql = "SELECT userId FROM logged_in_users WHERE sessionId='" . $sessionId . "'";
        $result = $db->select($sql);

        if($result != null)
            $id = $result["userId"];

        return $id;
    }

    static function getUserName($db, $userId){
        $name = "";

        $sql = "SELECT userName FROM users WHERE id=$userId";
        $result = $db->select($sql);

        if($result != null)
            $name = $result["userName"];

        return $name;
    }

    static function getLoggedInUserId($db){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $sessionId = session_id();

        return UserManager::getLoggedInUser($db, $sessionId);
    }

    static function userLogged($db){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $sessionId = session_id();

        if(UserManager::getLoggedInUser($db, $sessionId) == -1)
            return false;
        else
            return true;
    }

    static function userIsAdmin($db, $id){
        $sql = "SELECT `status` FROM users WHERE id=$id";
        $result = $db->select($sql);

        if($result['status'] == 2)
            return true;
        else
            return false;
    }

    static function checkLogedUserIsAdmin($db){
        session_start();
        $sessionId = session_id();
    
        $id = UserManager::getLoggedInUser($db, $sessionId);
        if($id != -1){
            $isAdmin = UserManager::userIsAdmin($db, $id);
            if(!$isAdmin)
                header("location: ../index.php");
        }else{
            header("location: ../index.php");
        }
    }
}
