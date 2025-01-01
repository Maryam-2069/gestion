<?php 
session_start();
require_once "cnx.php";

if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit;
}

$id_client = $_SESSION['id_client'];
$id_produit = $_GET['id_produit'];


$sql = "SELECT * FROM panier WHERE id_client = ? AND id_produit = ?";
$stm = $db->prepare($sql);
$stm->execute([$id_client, $id_produit]);
$pr = $stm->fetch(PDO::FETCH_OBJ);

if ($pr) {

    $newQuantity = $pr->quantite + 1;
    $updateSql = "UPDATE panier SET quantite = ? WHERE id_client = ? AND id_produit = ?";
    $updateStm = $db->prepare($updateSql);
    $updateStm->execute([$newQuantity, $id_client, $id_produit]);
} else {

    $sql = "INSERT INTO panier (id_produit, id_client, quantite) VALUES (?, ?, 1)";
    $stm = $db->prepare($sql);
    $stm->execute([$id_produit, $id_client]);
}

header("Location: panier.php");
exit;
?>
