<?php
include_once 'includes/header.php';
$user->checkLoginStatus();
$roleVal = $user->checkUserRole(10);

?>
<div class="container">
<?php 
if(isset($_GET['login'])){
    echo"
    <div class='alert alert-success' role='alert'>
    Welcome {$_SESSION['uname']}!
    </div>";
}



?>
</div>

<?php
include_once 'includes/footer.php';
?>