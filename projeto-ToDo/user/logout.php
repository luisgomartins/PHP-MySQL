<?php
session_start();
    
if (isset($_GET['logout'])) {
    unset($_SESSION["username"]);
    session_destroy();
    header('Location: ../index.php'); 
    exit();
    
}
?>
