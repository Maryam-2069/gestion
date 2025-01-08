<?php
session_start();
require_once "cnx.php";

$search = isset($_GET['search']) ? trim($_GET['search']) : "";

if (!empty($search)) {
    $sql = "SELECT * FROM produits WHERE nom_produit LIKE :search";
    $stm = $db->prepare($sql);
    $stm->execute(['search' => "%$search%"]);
} else {
    $sql = "SELECT * FROM produits";
    $stm = $db->prepare($sql);
    $stm->execute();
}
$rs = $stm->fetchAll(PDO::FETCH_OBJ);
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css?v-1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

    <nav>
        <h3 class="logo">Logo</h3>
        <ul class="navlinks">
            <li><a href="home.php">Shop</a></li>
            <li><a href="">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <form method="GET" action="home.php" style="text-align: center; margin: 20px;">
            <input type="text" name="search" placeholder="Search for products..." style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 5px;">
            <button type="submit" style="padding: 10px 20px; background-color: #C37463; color: white; border: none; border-radius: 5px; cursor: pointer;">Search</button>
        </form>
        <div class="icons">
            <a href="favorite.php"><img src="images/hearticon.png" style="width: 30px;"></a>
            <a href="panier.php"><img src="images/icons8-shop-30.png"></a>
            <?php
            if (!isset($_SESSION['id_client'])): ?>
                <button class="signup"><a href="SignUp.php">SignUp</a></button>
                <button class="signup"><a href="login.php">Login</a></button>
            <?php else: ?>
                <a href="profile_client.php"><img src="images/profile.png" style="width: 40px;"></a>
            <?php endif ?>

        </div>
    </nav>
    <?php if (empty($search)): ?>
        <section class="intro">
            <div class="text-content">
                <h3 class="title">Wear Your Confidence, <br> Shape Your Story</h3>
                <p class="paragraph">
                    Clothing is more than fabric; it’s an extension of who you are. <br>
                    The right outfit doesn’t just dress you—it empowers you. At MaryamStore,<br>
                    we believe in celebrating individuality through timeless designs and vibrant trends. <br>
                    Let your wardrobe tell your story—authentic, confident, and uniquely you.
                </p>
                <a href="#shop"><button class="shopbtn">Shop Now</button></a>
            </div>
            <img src="images/image.png" class="animated-lady">
        </section>
        <section class="shopitems">
            <div class="title_parag">
                <h2>What we have in our store</h2>
                <p>Shop our trendy , hight-quality clothig for only occasion . </p>
            </div>
            <div class="container_circles">
                <div class="circles">
                    <img src="images/iconpants.png" alt="">
                    <span class="titlecircles">Pants</span>
                </div>
                <div class="circles">
                    <img src="images/iconjacket.png" alt="">
                    <span class="titlecircles">Jackets</span>
                </div>
                <div class="circles">
                    <img src="images/iconheels.png" alt="">
                    <span class="titlecircles">Heels</span>
                </div>
                <div class="circles">
                    <img src="images/iconglasses.png" alt="">
                    <span class="titlecircles">Glasses</span>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!-- <?php
            require_once "cnx.php";
            $sql = "SELECT * FROM produits";
            $stm = $db->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            ?> -->
    <section class="shop" id="shop">
        <h2>Shop Now</h2>
        <div class="container_cards">
            <?php if (!empty($rs)): ?>
                <?php foreach ($rs as $r) : ?>
                    <div class="cardds">
                        <img src="<?php echo $r->image ?>" alt="Product Image">
                        <div class="foooter">
                            <span style="font-weight :bold;"><?php echo $r->nom_produit ?></span>
                            <p><?php echo $r->description ?></p>
                            <div class="images_container">
                                <span><?php echo $r->prix ?>DH</span>
                                <div>
                                    <a href="add_favorite.php?favorite_product=<?php echo $r->id_produit ?>&client=<?php echo $_SESSION['id_client'] ?? '' ?>" style=" text-decoration:none">
                                        <img src="images/hearticon.png" class="img">
                                    </a>
                                    <a href="add_panier.php?id_produit=<?php echo $r->id_produit ?>&client=<?php echo $_SESSION['id_client'] ?? '' ?>">
                                        <img src="images/icons8-shop-30.png">
                                    </a>

                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>

                <div class="message-container">
    <p>No products found for your search.</p>
</div>


            <?php endif; ?>
        </div>
    </section>
    <?php if (empty($search)): ?>
        <section class="contact" id="contact">
            <div class="container_contact">
                <h2>Contact Us</h2>
                <form action="" class="form">
                    <input type="text" placeholder="Name" class="inp"><br>
                    <input type="text" placeholder="Email" class="inp"><br>
                    <textarea placeholder="Message" class="inp"></textarea><br>
                    <input type="submit" value="Send" class="send" style="padding: 10px 20px; background-color: #C37463; color: white; border: none; border-radius: 5px; cursor: pointer;margin-bottom:10px">
                </form>
            </div>
        </section>
        <footer style="background-color: #C37463; color: white; padding: 20px 0;">
            <div class="container" style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px; max-width: 1200px; margin: auto;">
                <div style="flex: 1; min-width: 250px;">
                    <h3 style="margin-bottom: 10px;">About Us</h3>
                    <p style="line-height: 1.6;">
                        MaryamStore is your one-stop destination for trendy and high-quality clothing.
                        We believe in empowering confidence through timeless designs and vibrant trends.
                    </p>
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <h3 style="margin-bottom: 10px;">Quick Links</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href="home.php" style="color: white; text-decoration: none;">Shop</a></li>
                        <li><a href="#about" style="color: white; text-decoration: none;">About Us</a></li>
                        <li><a href="#contact" style="color: white; text-decoration: none;">Contact</a></li>
                        <li><a href="login.php" style="color: white; text-decoration: none;">Login</a></li>
                        <li><a href="SignUp.php" style="color: white; text-decoration: none;">Sign Up</a></li>
                    </ul>
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <h3 style="margin-bottom: 10px;">Contact Information</h3>
                    <p style="line-height: 1.6;">
                        <strong>Address:</strong> 123 Fashion Street, Cityville<br>
                        <strong>Email:</strong> <a href="" style="color: white; text-decoration: none;">info@maryamstore.com</a><br>
                        <strong>Phone:</strong> +123 456 7890
                    </p>
                    <div style="margin-top: 10px;">
                        <a href="" style="margin-right: 10px; text-decoration:none">
                            <img src="images/icons8-facebook-100.png" style="width: 24px; height: 24px;">
                        </a>
                        <a href="" style="margin-right: 10px;  text-decoration:none">
                            <img src="images/icons8-instagram-90.png" style="width: 24px; height: 24px;">
                        </a>
                        <a href="" style=" text-decoration:none">
                            <img src="images/icons8-x-100.png" style="width: 24px; height: 24px;">
                        </a>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                &copy; 2024 MaryamStore. All Rights Reserved.
            </div>
        </footer>
    <?php endif; ?>

</body>

</html>