<?php
session_start();
if(isset($_SESSION['email'])||isset($_SESSION['pw'])||
    isset($_SESSION['lastName'])||isset($_SESSION['firstName'])
    ||isset($_SESSION['id']))
{
    session_destroy();
    session_start();
    $_SESSION['Logout']="hi";
    header('refresh:0;url=index.php');
}