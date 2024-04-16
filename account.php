<?php
include_once 'includes/header.php';


$currUserData = $user->getUserInfo();

if(isset($_POST['updateUser'])){
    $updateFeedbackMessage = $user->checkUserInput($_POST['old_u_pass'], $_POST['old_u_rep_pass'], $currUserData['u_password']);

    if($updateFeedbackMessage == TRUE){
        $registerUser = $user->editUserInfo($_POST['uname'], $_POST['email'], $_POST['new_u_pass'], $currUserData['u_id']);
    }
    
    else{
        echo "ERROR";
    }

    if($registerUser == TRUE){
        echo "Succesfully updated account data";
    }

    else{
        echo "Error in updating your info";
    }
    
}

?>

<h2>Change account details</h2>
<form action="" method="POST">
  <label for="uname">Username: </label><br>
  <input type="text" id="uname" name="uname" value="<?php echo ($currUserData['u_name']); ?>"><br><br>
  <label for="email">Email:</label><br>
  <input type="text" id="email" name="email" value="<?php echo ($currUserData['u_email']); ?>"><br><br>
  <label for="u_pass">Enter Old Password:</label><br>
  <input type="password" id="old_u_pass" name="old_u_pass"><br><br>
  <label for="u_rep_pass">Repeat Old Password:</label><br>
  <input type="password" id="old_u_rep_pass" name="old_u_rep_pass"><br><br>
  <label for="u_pass">Enter New Password:</label><br>
  <input type="password" id="new_u_pass" name="u_pass"><br><br>
  <input type="submit" name="updateUser" value="Register">
</form><br>


<?php
include_once 'includes/footer.php';
?>