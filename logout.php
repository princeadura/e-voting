<?php
session_start();
if (isset($_SESSION["admin"])) {
    session_destroy();
    header("location: /register.php");
} else {
    session_destroy();
    header("location: /index.php");
}
