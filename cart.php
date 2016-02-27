<?php

session_start();
require_once('functions.php');

$message =$pr_name=$price=$carttotal="";

$user_id = $_SESSION['user_id'];

    if (isset($_POST['pid'])){
        $pr_id = $_POST['pid'];
        $pr_name = $_POST['pr_name'];
        $price= $_POST['price'];
        $quantity = $_POST['qty'];
        $status = "cart";


        $sql= "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$pr_id' AND status='cart'";

        $result = $conn->query($sql);

        if(mysqli_num_rows($result) == 0){

            $sql2="INSERT INTO cart (user_id,product_id,product_name,price,quantity,status,created_at)
                VALUES('$user_id','$pr_id','$pr_name','$price','$quantity','$status',NOW())";

                if($conn->query($sql2)===TRUE){
                    $message = 'Added to cart successfully!';
                }
        }else{

            while($row=mysqli_fetch_array($result)){
                $cart_id = $row['id'];

                $sql3 = "UPDATE cart SET quantity = '$quantity', updated_at=NOW() WHERE id='$cart_id'";

                if($conn->query($sql3)===TRUE){
                    $message = 'Quantity has been updated!';
                }
            }
         

        }

        
    }


// Deleting cart

    if (isset($_GET['did'])) {
        $delete_cart = $_GET['did'];
        if($conn->query("DELETE FROM cart WHERE id='$delete_cart'")){
            $message = "Item removed form cart successfully!";
        }
    }

// Deleting all from cart

    if (isset($_GET['cmd'])) {
        $delete_cart = $_GET['cmd'];
        if ($delete_cart ==="cart") {
             if($conn->query("DELETE FROM cart WHERE status='$delete_cart'")){
            $message = "All Iterm removed form cart successfully!";
        }
        }
       
    }

?>

<?php require_once('header.php'); ?>

    <div class="container">
        <div class="row">
        <?php echo $message; ?>
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Detail</th>
                            <th>Unit Price</th>
                            <th>Qnty</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $sql4 ="SELECT * FROM cart INNER JOIN products ON cart.product_id=products.pr_id WHERE cart.user_id='$user_id' AND cart.status='cart'";

                    $result2 = $conn->query($sql4);
                    if(mysqli_num_rows($result2) == 0){
                        $message = "Shopping cart is empty!";
                    }else{
                        while($row2=mysqli_fetch_array($result2)){
                            $carttotal += $row2['price']*$row2['quantity'];
                            
                            echo "<tr>";
                            echo "<td>".$row2['product_name']."
                            <br> <img src='".$row2['image']."' width='100' height='' /></td>";
                            echo "<td>".$row2['description']."</td>";
                            echo "<td>$".$row2['price']."</td>";
                            echo '<td><form method="post" action="cart.php">
                            <input type="number" name="qty" value="'.$row2['quantity'].'" maxsize="2"/>
                            <input type="hidden" name="pid" value="'.$row2['product_id'].'" />
                            <input type="hidden" name="pr_name" value="'.$row2['product_name'].'" />
                            <input type="hidden" name="price" value="'.$row2['price'].'" />
                            <input type="submit" value="Change" size="3" /> </form></td>';
                            echo '<td>$'.$row2['price']*$row2['quantity'].'</td>';
                            echo '<td><a href="cart.php?did='.$row2['id'].'" >Remove</a> </td>';
                            echo "</tr>";
                        }
                    }

                    ?>
                    </tbody>

                </table>
              <!-- <?php echo $checkout_btn; ?> -->

              <div class="pull-right "><a  class="btn btn-primary" href="checkout.php">Checkout</a>
              </div><br> <br>
                <div class="pull-right btn btn-default"><?php echo "Total: $".$carttotal; ?></div>
                <a class=" btn btn-warning pull-left" href="cart.php?cmd=cart">Click Here to Empty Your Shopping Cart</a>
            </div>
        </div>
    </div>




<?php require_once('footer.php'); ?>






