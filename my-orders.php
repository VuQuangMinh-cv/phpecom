<?php

include('functions/userfunctions.php');
include("includes/header.php");
include("authenticate.php");
?>

<div class="py-3 bg-primary">
    <div class="container">
        <h6 class="text-white">
            <a class="text-white" href="index.php">
                Home /
            </a>
            <a class="text-white" href="my-orders.php">
                My Orders
            </a>
            </h6>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tracking No</th>
                                <th>Price</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <body>
                        <?php
                        $orders = getOrders();

                        if(mysqli_num_rows($orders) > 0) {
                            foreach($orders as $item) {
                                ?>
                                    <tr>
                                        <td><?= $item['id']; ?></td>
                                        <td><?= $item['tracking_no']; ?></td>
                                        <td><?= $item['total_price']; ?></td>
                                        <td><?= $item['created_at']; ?></td>
                                        <td>
                                            <a href="view-order.php?t=<?= $item['tracking_no']; ?>" class="btn btn-primary">View Details</a>
                                        </td>

                                    </tr>
                                <?php
                            }
                        }else{
                            ?>
                            <tr>
                                <td colspan="5">No orders yet</td>
                            </tr>
                            <?php                        
                            }
                    ?>
                            
                        </body>
                    </table>
                    
                </div>
</div>
</div>
</div>
</div>

<?php include("includes/footer.php") ?>