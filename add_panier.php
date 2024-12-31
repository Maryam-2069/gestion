<?php 
session_start();
require_once "cnx.php";

if(!isset($_SESSION['id_client'])){
    header('location: login.php');
}


?>