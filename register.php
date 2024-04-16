<?php
include_once 'includes/header.php';

if(isset($_POST['createUser'])){
    $feedbackMessage = $user->checkUserRegisterInput($_POST['uname'], $_POST['email'], $_POST['u_pass'], $_POST['u_rep_pass']);

    if($feedbackMessage == "TRUE"){
    $registerUser = $user->register();
    }
    
}
?>

<h2>User Register</h2>
<form action="" method="POST">
  <label for="uname">Username:</label><br>
  <input type="text" id="uname" name="uname"><br><br>
  <label for="email">Email:</label><br>
  <input type="text" id="email" name="email"><br><br>
  <label for="u_pass">Enter Password:</label><br>
  <input type="password" id="u_pass" name="u_pass"><br><br>
  <label for="u_rep_pass">Repeat Password:</label><br>
  <input type="password" id="u_rep_pass" name="u_rep_pass"><br><br>
  <input type="submit" name="createUser" value="Register">
</form><br>


<?php
include_once 'includes/footer.php';
?>