<?php 
require_once "cnx.php";
if(isset($_GET['id_produit'])){
    $sq = "DELETE FROM produits where id_produit = ?";
    $sql = $db->prepare($sq);
    $stm = $sql->execute($_GET['id_produit']);
    if($stm){
        header("location:admin_produit.php");
    }
}