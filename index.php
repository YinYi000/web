<?php

include 'config.php';
session_start();
//$user_id = $_SESSION['user_id']
;
$user_id ="";
if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity']+$product_quantity;

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      $message[] = 'product added to cart!';
   }

};

if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'cart quantity updated successfully!';
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:index.php');
}
  
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:index.php');
}

?>





<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<html>
    <head>
        <title>Redmi</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
        <!--font awesome cdn link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">     
        <!-- link css et js-->
        <link rel="stylesheet" href="style.css">     
    </head>
    
    <body>  
    <!--header section -->  
    <header class="header">
        <img src="image/mi.png" width="40" height="40" />   <!--logo redmi-->
        
        <nav class="navbar">
            <a href="#telephones">téléphone</a>       <!-- link of Boutique -->
            <a href="#TVs">télévision</a>    <!-- link of Smartphone -->
            <a href="#review">commentaires</a>    <!-- link of Smart Home -->
        </nav>
        
        <div class="icons">
            <div class="fas fa-bars" id="menu-btn"></div>         <!-- button of menu -->
            <div class="fas fa-search" id="search-btn"></div>      <!-- button of search -->
            <div class="fas fa-shopping-cart" id="cart-btn"></div>   <!-- button of shopping-cart -->
            <div class="fas fa-user" id="login-btn"></div>             <!-- button of login -->
        </div>
        
        <form action="" class="search-form">
            <input type="search" id="search-box" placeholder="search here...">   <!-- search input formulaire-->
            <label for="search-box" class="fas fa-search"></label>      <!-- label of search -->
        </form>
        
        <div class="shopping-cart">    <!-- block of shopping-cart -->
            <div class="box">               
            </div>
            <a href="shoppingcar.php" class="btn">Voir mon panier</a>
            
        </div>

        <div  class="login-form" >     <!-- block of login -->
            <p><a href="connection.php">     Se connecter </a></p>
            <a href="inscription.php"> S'inscrire</a>
        </div>   
        
        
        
    </header>
    <?php
    
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?> 
    
    <!--Home section starts -->
    <section class="home" id="home">
        <div class="content">
            <h3>Redmi Note 11 Pro+5G</h3>
            <p>HyperCharge 120W|Écran AMOLED DotDisplay 120 Hz FHD+</p>
            <p id="prix">Des 399.90€</p>
        
        </div>
    </section>
    
    
    
    
    
    
    
    


    <!--Home section ends --> 

    <section class="telephones" id="telephones">
        
        <h1 class="heading">  Redmi<span>téléphone</span> </h1>
       <div class="products">
        <div class="box-container">

   <?php
      $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
      if(mysqli_num_rows($select_product) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_product)){
   ?>
      <form method="post" class="box" action="">
         <img src="image/<?php echo $fetch_product['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_product['name']; ?></div>
         <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
         <input type="number" min="1" name="product_quantity" value="1">
         <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
   <?php
      };
   };
   ?>

   </div>

</div>
    </section>
    <section class="TVs" id="TVs">
        <h1 class="heading">  Redmi<span>télévision</span> </h1>
        <div class="swiper TVs-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide box">
                <img src="image/TV1.jpg" alt="">
                <h3>Xiao mi TV1</h3>
                <p>199€</p>
                <a href="#" class="btn">add to cart</a>
            </div>
            <div class="swiper-slide box">
                <img src="image/TV2.jpg" alt="">
                <h3>Xiao mi TV2</h3>
                <p>399€</p>
                <a href="#" class="btn">add to cart</a>
            </div> 
            <div class="swiper-slide box">
                <img src="image/TV3.jpg" alt="">
                <h3>Xiao mi TV3</h3>
                <p>299€</p>
                <a href="#" class="btn">add to cart</a>
            </div>
            <div class="swiper-slide box">
                <img src="image/TV4.jpg" alt="">
                <h3>Xiao mi TV4</h3>
                <p>399€</p>
                <a href="#" class="btn">add to cart</a>
            </div>                   
        </div>
        </div>
    </section>   
    
<section class="review" id="review">

    <h1 class="heading"> Les <span>Commentaires</span> </h1>

    <div class="swiper review-slider">

        <div class="swiper-wrapper">

            <div class="swiper-slide box">
                <img src="image/pic-1.png" alt="">
                <p>Développe toujours des produits intéressants!</p>
                <h3>fakjf djaofj</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="image/pic-2.png" alt="">
                <p>La qualité du téléphone est particulièrement bonne!</p>
                <h3>john hfiaof</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="image/pic-3.png" alt="">
                <p>Excellent service, il m'a aidé à résoudre de nombreux problèmes liés à mon achat.</p>
                <h3>fhlkwqfn deo</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="image/pic-4.png" alt="">
                <p>La livraison a été exceptionnellement rapide!</p>
                <h3>jgspg sdo</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>
    </section>    
    <section class="footer">
    <div class="box-container">
        <div class="box">
            <h3> SUIVEZ-NOUS</h3>
            <div class="share">
                <a href="https://www.facebook.com" class="fab fa-facebook-f"></a>
                <a href="https://twitter.com/" class="fab fa-twitter"></a>
                <a href="https://www.instagram.com/" class="fab fa-instagram"></a>
                <a href="https://www.linkedin.com" class="fab fa-linkedin"></a>
            </div>
        </div>
        <div class="box">
            <h3>NOUS CONTACTER</h3>
            <a href="#" class="links"> <i class="fas fa-phone"></i> +123-456-789 </a>
            <a href="#" class="links"> <i class="fas fa-envelope"></i> Redmi@gmail.com </a>
            <a href="#" class="links"> <i class="fas fa-map-marker-alt"></i> Reims France </a>
        </div>
        <div class="box">
            <h3>Liens rapides</h3>
            <a href="#home" class="links"> <i class="fas fa-arrow-right"></i> home </a>
            <a href="#telephones" class="links"> <i class="fas fa-arrow-right"></i> telephones </a>
            <a href="#TVs" class="links"> <i class="fas fa-arrow-right"></i> TVs </a>
            <a href="#" class="links"> <i class="fas fa-arrow-right"></i> review </a>
        </div>
        <div class="box">
            <h3>RESTONS EN CONTACT</h3>
            <input type="email" placeholder="e-mail" class="email">
            <input type="submit" value="s'abonner" class="btn">
            <img src="image/payment.png" class="payment-img" alt="">
        </div>
    </div>
    <div class="credit"> created by <span>  WeiYi LIU et Yi YIN </span> | all rights reserved </div>
</section>
    <!-- js link -->
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="style.js"></script>
    </body>
</html>
