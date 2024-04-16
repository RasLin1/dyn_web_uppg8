<?php
include_once 'includes/header.php';


if(isset($_GET['newuser'])){
    echo"
    <div class='alert alert-success' role='alert'>
    Succesfull Account Creation!
    </div>";
}

if(isset($_POST['login'])){

    $loginUser = $user->login($_POST['uname'], $_POST['u_pass']);

    if($loginUser == "true"){
        echo "Login Success";
    }

    elseif($loginUser == "falsen"){
        echo "<div class='alert alert-danger' role='alert'>
        Wrong username or email!
        </div>";
    }

    elseif($loginUser == "falsep"){
        echo "<div class='alert alert-danger' role='alert'>
        Wrong password!
        </div>";
    }
}
?>

<h2>User Login</h2>
<form action="" method="POST">
  <label for="uname">Username or Email:</label><br>
  <input type="text" id="uname" name="uname" required="required"><br><br>
  <label for="u_pass">Enter Password:</label><br>
  <input type="password" id="u_pass" name="u_pass"><br><br>
  <input type="submit" name="login" value="Login">
</form><br>

<form action="register.php">
    <input type="submit" value="Register"></input>
</form>

<?php
include_once 'includes/footer.php';
?>