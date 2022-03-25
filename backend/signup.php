<?php
//error_reporting(0);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
header("Content-type:application/json");

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


Class Auth extends Database {
    public function signup($fname,$lname,$email,$phone,$pass) {
        $sql = "INSERT INTO users(fname,lname,email,phone,pass) VALUES (:fname,:sname,:email,:pass)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fname'=>$fname,'sname'=>$sname,'email'=>$email,'pass'=>$pass]);
        return true;
    }
    public function login($username,$psw){
        $sql = "SELECT * FROM accounts WHERE Email = :username AND Pass = :psw";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username'=>$username,'psw'=>$psw]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}


$db = new Auth();

$response = array();
//
//Account Register
if (isset($_POST['fname']) || isset($_POST['lname']) || isset($_POST['phoneno']) || isset($_POST['email']) || isset($_POST['password'])) {
    $fname = $db->test_input($_POST['fname']);
    $lname = $db->test_input($_POST['sname']);
    $email = $db->test_input($_POST['email']);
    $phoneno = $db->test_input($_POST['phoneno']);
    $pass = $db->test_input($_POST['password']);

$signup = $db->signup($fname,$lname,$email,$phoneno,$pass);

if ($signup === TRUE) {
    $response = array(
        'status' => 'success',
        'message' => 'You have successfully created an account'
    );
} else {
    $response = array(
        'status' => 'failure',
        'message' => 'An error occured while! try again later'
    );    
} 
echo json_encode($response);
}

//login
if(isset($_POST['username']) || isset($_POST['password'])) {
    $data = $db->login($_POST['username'],$_POST['password']);
    if ($data != null) {
        $response = array(
            'status' => 'success',
            'message' => $data
        );
    } else {
        $response = array(
            'status' => 'failed',
            'message' => 'Either the password or Email is wrong'
        );
    }
   echo json_encode($response); 
}

?>