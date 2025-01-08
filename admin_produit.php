<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin.css?v1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="dashboard">
            <img src="images/profile.png" alt="Profile" class="profile-img">
            <ul>
                <li>
                    <img src="images/clients.png" alt="Clients Icon">
                    <a href="admin_client.php">Clients</a>
                </li>
                <li>
                    <img src="images/order.png" alt="Orders Icon">
                    <a href="admin_orders.php">Orders</a>
                </li>
                <li>
                    <img src="images/product.png" alt="Products Icon">
                    <a href="admin_produit.php">Products</a>
                </li>
                <li>
                    <img src="images/logout.png" alt="Logout Icon">
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>

        <?php
        require_once "cnx.php";
        $sql = "SELECT * from produits ";
        $stm = $db->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_OBJ);

        session_start();
        if (!isset($_SESSION['id_client'])) {
            header("Location: login.php");
            exit;
        }

        if (isset($_GET['id_produit'])) {
            $id_produit = $_GET['id_produit'];
        
            if (!empty($id_produit)) { 
                try {
                  
                    $db->beginTransaction();
        
                  
                    $sql = "DELETE FROM favorites WHERE product_id = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([$id_produit]);
        
                    $sql = "DELETE FROM panier WHERE id_produit = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([$id_produit]);
        
                 
                    $sq = "DELETE FROM produits WHERE id_produit = ?";
                    $stmt = $db->prepare($sq);
                    $stmt->execute([$id_produit]);
        
                   
                    $db->commit();
        
                 
                    header("Location: admin_produit.php");
                    exit;
                } catch (PDOException $e) {
                    $db->rollBack();
                    echo "Error: " . $e->getMessage();
                }
            } 
        }
        


        ?>
        <div class="content">
            <div class="cnt1">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Products</h1>
                    <button class="add_neww"><a href="addproduit.php">Add Product</a></button>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Description</th>
                            <th scope="col" style="padding-left: 80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $r): ?>
                            <tr>
                                <td><?php echo $r->id_produit ?></td>
                                <td><?php echo $r->nom_produit ?></td>
                                <td><?php echo $r->prix ?></td>
                                <td><?php echo $r->stock ?></td>
                                <td><?php echo $r->description ?></td>
                                <td>
                                    <a href="updateproduit.php?id_produit=<?php echo $r->id_produit ?>">
                                        <img src="images/modify.png" style="width: 30px ;margin-left :55px">
                                    </a>
                                    <a
                                        href="admin_produit.php?id_produit=<?php echo $r->id_produit; ?>"
                                        onclick="return confirm('Are you sure you want to delete product ID <?php echo $r->id_produit; ?>?');">
                                        <img src="images/trash.png"style="width: 30px ;">
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</body>

</html>