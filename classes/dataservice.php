<?php
    class dataservice{
        private $server;
        private $username;
        private $password;
        private $database;
        private $conn = null;

        public function __construct(){
            if(file_exists('toai-config.php')){
                require_once('toai-config.php');
            }
            if(file_exists('../toai-config.php')){
                require_once('../toai-config.php');
            }
            if(file_exists('../../toai-config.php')){
                require_once('../../toai-config.php');
            }

            $sc = new SystemConfig();
            $this->server = $sc->getServer();
            $this->username = $sc->getUsername();
            $this->password = $sc->getPassword();
            $this->database = $sc->getDatabase();

            $options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);

            $connectionString = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $this->server, $this->database);
            try {
                $this->conn = new PDO($connectionString, $this->username, $this->password, $options);
            } catch (PDOException $e) { 
				echo $e->getMessage();
			}
        }

        public function __destruct() {   
            $this->conn = null;
        }

        public function ExecuteQuery($i_sql){
			$resource = $this->conn->query($i_sql);			
            $result_array = array();
            if($resource)
            {
                $num_rec = 0;               
				while (($row = $resource->fetch(PDO::FETCH_BOTH)))
                {
                    $result_array[$num_rec] = $row;
                    $num_rec++;
                }                
                if($num_rec > 0)
                    return $result_array;
            }
            return false;
        }

        public function ExecuteNonQuery($i_sql){
			try{
				$stmt = $this->conn->prepare($i_sql);
				$stmt->execute();
				return true;
			}catch(PDOException $e){ 
				RunLogErrorQuery($i_sql,$e->getMessage());
				return false;
			}
        }
    }
?>