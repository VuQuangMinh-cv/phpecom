<?php
include("functions/userfunctions.php");
include("includes/header.php");
include("includes/slider.php");

?>
<style>
   .product-image {
      width: 100%;
      height: 230px; 
      object-fit: cover; 
   }
</style>
<div class="py-5">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h4>Trending Products</h4>
            <div class="underline mb-2"></div>
            <hr>
               <div class="owl-carousel">

                
            <?php
               $trendingProducts = getAllTrending();
               if(mysqli_num_rows($trendingProducts) > 0) {
                  foreach($trendingProducts as $item) {
                     ?>
                            <div class="item">
                                <a href="product-view.php?product=<?= $item['slug']; ?>">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <img src="uploads/<?= $item['image']; ?>" alt="Product Image" class="w-100 product-image">
                                            <h5 class="text-center"><?= $item['name'] ?></h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
               }
            }
            ?>
                </div> 
               </div>
      </div>
   </div>
</div>

   <div class="py-5 bg-f2f2f2">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h4>About Us</h4>
            <div class="underline mb-2">

               </div>
               <p> WE are here to Listen YOU </p>
               <p> Buy anything you like! </p>

   </div>
   </div>
   </div>
   </div>

   <div class="py-5 bg-dark">
   <div class="container">
      <div class="row">
         <div class="col-md-3">
            <h4 class="text-white">E.Miu-Shop</h4>
            <div class="underline mb-2"></div>
            <a href="index.php" class="text-white"> <i class="fa fa-angle-right"></i> Home </a> <br>
            <a href="my-orders.php" class="text-white"> <i class="fa fa-angle-right"></i> Your Orders </a> <br>
            <a href="cart.php" class="text-white"> <i class="fa fa-angle-right"></i> My Cart </a> <br>
            <a href="categories.php" class="text-white"> <i class="fa fa-angle-right"></i> Our Collection </a>
         </div>
         <div class="col-md-3">
            <h4 class="text-white">Address</h4>
            <p class="text-white">
            112/8 Alley, Me Tri Thuong Street
            Ward Me Tri, Nam Tu Liem District
            Hanoi 100000
            Vietnam
            </p>
            <a href="tel:+0123456789" class="text-white"><i class="fa fa-phone"> + 0123 456 789</i></a>
            <a href="mailto:xyz@gmail.com" class="text-white"><i class="fa fa-envelope"> xyz@gmail.com</i></a>
         </div>
      </div>
   </div>
   </div>


<?php include("includes/footer.php") ?>

<script>
   $(document).ready(function (){

   
   $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
   })

});
</script>