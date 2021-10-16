<?php
    class Baza {
        private $mysqli;

        public function __construct() {
            require "config.php";

            $this->mysqli = new mysqli($db_server, $db_user, $db_password, $db_database);

            if ($this->mysqli->connect_errno) {
                printf("Nie udało sie połączenie z serwerem: %s\n",

                $this->mysqli->connect_error);
                exit();
            }
            

            if ($this->mysqli->set_charset("utf8")) {
            //udało sie zmienić kodowanie
            }
        }
        
        function __destruct() {
            $this->mysqli->close();
        }
        
        public function select($sql) {
            if ($result = $this->mysqli->query($sql)) {
                return $result->fetch_array();
            }
        }

        public function selectRaw($sql) {
            if ($result = $this->mysqli->query($sql)) {
                return $result;
            }
        }

        public function selectFetchAll($sql) {
            if ($result = $this->mysqli->query($sql)) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }

        public function selectAndFormat($sql, $pola) {
            $tresc = "";
            
            if ($result = $this->mysqli->query($sql)) {
                $ilepol = count($pola);
                $ile = $result->num_rows;

                $tresc.="<table><tbody>";

                while ($row = $result->fetch_object()) {
                    $tresc.="<tr>";

                    for ($i = 0; $i < $ilepol; $i++) {
                        $p = $pola[$i];
                        $tresc.="<td>" . $row->$p . "</td>";
                    }

                    $tresc.="</tr>";
                }

                $tresc.="</table></tbody>";
                $result->close();
            }

            return $tresc;
        }

        public function insert($sql) {
            return $this->mysqli->query($sql);
        }

        public function getLastInserterdIndex(){
            return $this->mysqli->insert_id;
        }

        public function delete($sql) {
            return $this->mysqli->query($sql);
        }

        public function update($sql) {
            return $this->mysqli->query($sql);
        }

        public function selectUser($login, $passwd, $table) {
            $id = -1;
            $sql = "SELECT * FROM $table WHERE userName='" . $login . "'";

            if ($result = $this->mysqli->query($sql)) {
                $ile = $result->num_rows;

                if ($ile == 1) {
                    $row = $result->fetch_object();
                    $hash = $row->passwd;
                
                    if (($passwd === $hash))
                        $id = $row->id;
                }
            }

            return $id;
        }
    }
?>