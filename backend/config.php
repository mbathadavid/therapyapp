<?
Class Database {
    private $dsn = "mysql:host=localhost;dbname=therapy";
    private $dbuser = "root";
    private $dbpass = "";
    public $conn;
    
    //connect the database
    public function __construct(){
       try {
           $this->conn = new PDO($this->dsn,$this->dbuser,$this->dbpass);
       } catch (PDOException $e) {
           echo "Error".$e->getMessage();
       } 
       return $conn;
    }
    //function to sanitize data
    public function test_input($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}


?>