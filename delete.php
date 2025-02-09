<?php
require_once "classes/User.php";

if (isset($_GET["id"])) {
    $user = new User();
    if ($user->deleteUser($_GET["id"])) {
        header("Location: index.php");
        exit();
    }
}
?>
