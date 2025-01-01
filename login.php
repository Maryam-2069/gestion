    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="signup.css">
    </head>

    <body>
        <nav>
            <h3 class="logo">Logo</h3>
            <ul class="navlinks">
                <li><a href="home.php">Shop</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Contact</a></li>
            </ul>
            <div class="icons">
                <img src="images/icons8-shop-30.png">
                <button class="signup"><a href="SignUp.php">SignUp</a></button>
            </div>
        </nav>
        <?php
        session_start();
        require_once "cnx.php";
        if (isset($_POST['sub'])) {
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $sql = "SELECT * from clients WHERE email= ? ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if ($result) {
                if (password_verify($pass,$result->pasword)) {
                    $_SESSION['id_client'] = $result->id_client;
                    $_SESSION['nom_client'] = $result->nom_client;
                    $_SESSION['admin'] = $result->admin;
                    if ($_SESSION['admin'] === 1) {
                        header('location: admin_client.php');
                    } else {
                        header('Location: home.php');
                    }
                }
            }
        }
        ?>
        <div class="container mt-5 login">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mxb-4 text-center">Login</h4>
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input class="form-control" type="email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control" type="password" name="pass">

                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="send" name="sub">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>