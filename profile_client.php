<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="dashboard">
            <img src="images/profile.png" alt="Profile" class="profile-img">
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
                    <img src="images/icons8-cart-50.png" alt="Clients Icon">
                    <a href="">Orders</a>
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
        if (isset($_POST['submit'])) {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $adresse = $_POST['adresse'];
            $telephone = $_POST['tel'];
            $pass = $_POST['pass'];
            $confirm = $_POST['confirm'];

            if (!empty($nom) && !empty($email) && !empty($adresse) && !empty($telephone) ) {
                $sql = "UPDATE clients SET nom_client = ?, email = ?, adresse = ?, telephone = ? where id_client = ?";
                $stm = $db->prepare($sql);
                $stm->execute([$nom, $email, $adresse, $telephone, $id_client]);
                $_SESSION['nom_client'] = $nom;
                header("Location:profile_client.php");
            }
        }

        ?>

        <div class="cnt">
        <h2 >Welcome <?php echo $_SESSION['nom_client'] ?></h2>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="nom" value="<?php echo $result->nom_client; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control"  name="email" value="<?php echo $result->email; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control"  name="adresse" value="<?php echo $result->adresse; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tel" class="form-label">Telephone</label>
                        <input type="tel" class="form-control" id="tel" name="tel" value="<?php echo $result->telephone; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="adresse" class="form-label">Paasword</label>
                        <input type="text" class="form-control"  name="pass"required placeholder="Enter Your Paasword">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tel" class="form-label">Confirm password</label>
                        <input type="tel" class="form-control"  name="confirm" placeholder="Confirm Your Paasword">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="updt" name="submit">Update</button>
                    </div>
                </div>
            </form>

        </div>

        <!-- <div class="content">
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
        </div> -->
    </div>

</body>

</html>