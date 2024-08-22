<?php
    session_start();
    $userInfo = $_SESSION['userInfo'] ?? null;
    if($userInfo) {
        session_destroy();
        header('Location: login.php');
    } else{
        header('Location: login.php');
    }
?>