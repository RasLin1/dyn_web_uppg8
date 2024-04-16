<?php
class User {
    public $username;
    public $email;
    private $password;
    public $role;
    private $status;
    public $pdo;
    private $errorMessages = [];
    private $errorState = 0;

    function __construct($pdo){
        $this->role = 4;
        $this->username = "RandomGuest";
        $this->pdo = $pdo;
    }

    //makes the data safe
    private function cleanInput($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

    public function checkUserRegisterInput($uname, $umail, $upass, $upassrep){
        $errorMessages = [];
        $errorState = 0;
        //Check if username exists or email exists
        $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM users WHERE u_name = :uname OR u_email = :email');
        $stmt_checkUsername->bindParam(":uname", $uname, PDO::PARAM_STR);
        $stmt_checkUsername->bindParam(":email", $umail, PDO::PARAM_STR);
        $stmt_checkUsername->execute();

        if($stmt_checkUsername->rowCount() > 0){
            array_push($errorMessages,"Username or email is already taken!");
            $errorState = 1;
        }

        //check if password and password repeat are the same

        if ($upass !== $upassrep){
            array_push($errorMessages," Password's don't match!");
            $errorState = 1;
        }

        //check if password is long enough
        else {
            if(strlen($upass) < 8){
                array_push($errorMessages," Password is to short!");
                $errorState = 1;
            }
        }

        //check if email is valid
        if (!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
            array_push($errorMessages," Email isn't valid!");
            $errorState = 1;
        }

        if ($errorState == 0){
            return "TRUE";
        }
        
        elseif ($errorState !== 0){
            return $errorMessages;
        }
        
        
    }

    //function that creates an account
    public function register(){
        $regUserName = cleanInput($_POST['uname']);
        $regUserMail = $_POST['email'];
        //encrypts the password with password_hash()
        $encryptedPassword = password_hash($_POST['u_pass'], PASSWORD_DEFAULT);

        $stmt_registerUser = $this->pdo->prepare("INSERT INTO users(u_name, u_email, u_password, u_role_fk, u_status)values(:uname, :umail, :upass, 1, 1)");
        $stmt_registerUser->bindParam(":uname" ,$regUserName, PDO::PARAM_STR);
        $stmt_registerUser->bindParam(":umail" ,$regUserMail, PDO::PARAM_STR);
        $stmt_registerUser->bindParam(":upass" ,$encryptedPassword, PDO::PARAM_STR);

        if($stmt_registerUser->execute()){
            header("Location: index.php?newuser=1");
        }
        else{
            return "Something went wrong";
        }
    }

    public function login($usernameEmail, $upass){
        $stmt_checkIfUserExists = $this->pdo->prepare("SELECT * FROM users WHERE u_name = :uname OR u_email = :email");
		$stmt_checkIfUserExists->bindValue(":uname", $usernameEmail, PDO::PARAM_STR);
		$stmt_checkIfUserExists->bindValue(":email", $usernameEmail, PDO::PARAM_STR);
		$stmt_checkIfUserExists->execute();
		//Creates an array for the selected data
		$userData = $stmt_checkIfUserExists->fetch();
		
		if(!$userData){
			$errorMessages = "No such user or email in database.";
			$errorState = 1;
            return "falsen";
		}
        
        //checks that the passwords match
        elseif($userData){
		   $checkPasswordMatch = password_verify($upass, $userData['u_password']);
        }

		   if($checkPasswordMatch == true) {
				$_SESSION['uname'] = $userData['u_name'];
				$_SESSION['urole'] = $userData['u_role_fk'];
				$_SESSION['uid'] = $userData['u_id'];
				header("Location: home.php?login=1");
		   } 
		   else {
			  $errorMessages = "INVALID password";     
			  return "falsep";
		   }
    }

    //checks if you are logged in
    public function checkLoginStatus(){
        if(isset($_SESSION['uid'])){
            return true;
        }
        else{
            header("Location: index.php");
            return false;
        }
    }

    //logout function that destroy's the session and redirects to login
    public function logout(){
        session_unset();
        session_destroy();
        header("Location: index.php");
    }

    //general redirect function
    public function redirect($url){
        header("Location: $url");
    }

    //this is supposed to check your current role by the value
    public function checkUserRole($reqVal){
        $stmt_checkUserRole = $this->pdo->prepare("SELECT * FROM user_roles WHERE r_id = :rid");
        $stmt_checkUserRole->bindValue(':rid', $_SESSION['urole'], PDO::PARAM_STR);
        $stmt_checkUserRole->execute();
        $results = $stmt_checkUserRole->fetch();
        
        if($results >= $reqVal){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function getUserInfo(){
		$userInfoQuery = $this->pdo->prepare("SELECT * FROM users WHERE u_id = :uid");
		$userInfoQuery->bindParam(":uid", $_SESSION['uid'], PDO::PARAM_INT);
		$userInfoQuery->execute();
		$userInfo = $userInfoQuery->fetch();
		return $userInfo;
	}

    public function editUserInfo($uname, $umail, $upass, $uid){
        $regUserName = cleanInput($_POST['uname']);
        $regUserMail = $_POST['email'];
        //encrypts the password with password_hash()
        $encryptedPassword = password_hash($_POST['u_pass'], PASSWORD_DEFAULT);

        $stmt_registerUser = $this->pdo->prepare("UPDATE users(u_name, u_email, u_password, u_role_fk, u_status)values(:uname, :umail, :upass, 1, 1) WHERE u_id = $uid");
        $stmt_registerUser->bindParam(":uname" ,$regUserName, PDO::PARAM_STR);
        $stmt_registerUser->bindParam(":umail" ,$regUserMail, PDO::PARAM_STR);
        $stmt_registerUser->bindParam(":upass" ,$encryptedPassword, PDO::PARAM_STR);

        if($stmt_registerUser->execute()){
            header("Location: index.php?newuser=1");
        }
        else{
            return "Something went wrong";
        }
    }


}
?>