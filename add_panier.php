<?php 
session_start();
require_once "cnx.php";

// Ensure the client is logged in
if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit;
}

$id_client = $_SESSION['id_client'];
$id_produit = $_GET['id_produit'];

// Check if the product already exists in the cart for this client
$sql = "SELECT * FROM panier WHERE id_client = ? AND id_produit = ?";
$stm = $db->prepare($sql);
$stm->execute([$id_client, $id_produit]);
$existingProduct = $stm->fetch(PDO::FETCH_OBJ);

if ($existingProduct) {
    // If the product already exists, update the quantity (increase by 1)
    $newQuantity = $existingProduct->quantite + 1;
    $updateSql = "UPDATE panier SET quantite = ? WHERE id_client = ? AND id_produit = ?";
    $updateStm = $db->prepare($updateSql);
    $updateStm->execute([$newQuantity, $id_client, $id_produit]);
} else {
    // If the product does not exist, insert a new row
    $insertSql = "INSERT INTO panier (id_produit, id_client, quantite) VALUES (?, ?, 1)";
    $insertStm = $db->prepare($insertSql);
    $insertStm->execute([$id_produit, $id_client]);
}

// Redirect to the cart page after adding the product
header("Location: panier.php");
exit;
?>
