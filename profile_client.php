<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin.css?v1">
</head>

<body>
    <div class="container">
        <div class="dashboard">
            <img src="images/profile.png" alt="Profile" class="profile-img">
            <span class="nom"><?php echo strtoupper($_SESSION['nom_client']); ?></span>
            <ul>
                <li>
                    <img src="images/details.png" alt="Clients Icon">
                    <a href="">Personal Details</a>
                </li>
                <li>
                    <img src="images/heart.png" alt="Clients Icon">
                    <a href="">Favorite</a>
                </li>
                <li>
                    <img src="images/password.png" alt="Orders Icon">
                    <a href="admin_orders.php">Change Password</a>
                </li>
                <li>
                    <img src="images/logout.png" alt="Logout Icon">
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
        <?php
        require_once "cnx.php";
        if (!isset($_SESSION['id_client'])) {
            header("Location:login.php");
        }
        $id_client = $_SESSION['id_client'];
        $sql = "SELECT * from clients where id_client = ?";
        $stm = $db->prepare($sql);
        $stm->execute([$id_client]);
        $result = $stm->fetch(PDO::FETCH_OBJ);
        ?>
        <div class="content">
            <div class="cnt1">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Clients</h1>
                    
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

                        <tr>
                            <td><?php echo $result->id_client ?></td>
                            <td><?php echo $result->nom_client ?></td>
                            <td><?php echo $result->email ?></td>
                            <td><?php echo $result->adresse ?></td>
                            <td><?php echo $result->telephone ?></td>
                            <td>
                                <a href="updateclient.php?id_client=<?php echo $result->id_client ?>">
                                    <button class="update">Update</button>
                                </a>
                               
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>