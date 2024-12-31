<?php
$user = 'root';
$password = '';
$host = "localhost";
$dbname = "gestion_magasin";

$db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);