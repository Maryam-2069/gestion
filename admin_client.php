<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin.css?">
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
        $sql = "SELECT * from clients ";
        $stm = $db->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
        session_start();
        if (!isset($_SESSION['id_client'])) {
            header("Location: login.php");
            exit;
        }



        ?>
        <div class="content">
            <div class="cnt1">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Clients</h1>
                    <button class="add_neww"><a href="addclient.php">Add Clients</a></button>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Adresse</th>
                            <th scope="col">Telephone</th>
                            <th scope="col" style="padding-left: 80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $r): ?>
                            <tr>
                                <td><?php echo $r->id_client ?></td>
                                <td><?php echo $r->nom_client ?></td>
                                <td><?php echo $r->email ?></td>
                                <td><?php echo $r->adresse ?></td>
                                <td><?php echo $r->telephone ?></td>
                                <td>
                                    <a href="updateclient.php?id_client=<?php echo $r->id_client ?>">
                                        <img src="images/modify.png" style="width: 30px ;margin-left :55px">
                                    </a>
                                    <img src="images/trash.png" style="width: 30px;">
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