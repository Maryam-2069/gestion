<?php 
session_start();
require_once "cnx.php";

if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit;
}

$id_client = $_SESSION['id_client'];
$id_produit = $_GET['favorite_product'];

$sql = "SELECT * FROM favorites WHERE client_id = ? AND product_id = ?";
$stm = $db->prepare($sql);
$stm->execute([$id_client, $id_produit]);
$fv = $stm->fetch(PDO::FETCH_OBJ);

if ($fv) {
    echo "Product is already in your favorites.";
} else {

    $sqll = "INSERT INTO favorites (client_id, product_id) VALUES (?, ?)";
    $sttm = $db->prepare($sqll);
    $sttm->execute([$id_client, $id_produit]);

    if ($insertStm) {
        echo "Product added to your favorites.";
    } else {
        die("Error adding product to favorites.");
    }
}

header("Location: favorite.php"); 
exit;
?>
