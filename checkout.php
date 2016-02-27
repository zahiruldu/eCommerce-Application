<?php

session_start();
require_once('functions.php');

$user_id = $_SESSION['user_id'];
$carttotal = $message = "";

if (isset($_POST['total'])) {
	$total = $_POST['total'];
	$payment = $_POST['payment'];
	$status = "ordered";

	$sql="INSERT INTO orders (customer_id,total_amount,status,payment,created_at)
			VALUES('$user_id','$total','$status','$payment',NOW())";
		if ($conn->query($sql)===TRUE) {
			$order_id = $conn->insert_id;
			
			$sql2 = "UPDATE cart SET order_id='$order_id', status='order' WHERE user_id='$user_id' AND status='cart'";
			if($conn->query($sql2)===TRUE){
				header('location:thanks.php?sms=Thanks');
				
			}
		}
}


?>
<?php require_once('header.php'); ?>

<div class="container">
	<div class="row">
		<div class="col-sm-3 pull-right">
			<h2>Order details</h2>
			<?php 
                    $sql4 ="SELECT * FROM cart INNER JOIN products ON cart.product_id=products.pr_id WHERE cart.user_id='$user_id' AND cart.status='cart'";

                    $result2 = $conn->query($sql4);
                    if(mysqli_num_rows($result2) == 0){
                        $message = "Shopping cart is empty!";
                    }else{
                    	echo '<table>';
                        while($row2=mysqli_fetch_array($result2)){
                            $carttotal += $row2['price']*$row2['quantity'];
                            
                            echo "<tr>";
                            echo '<td>'.$row2['product_name'].'</td>';
                            echo '<td>$'.$row2['price']*$row2['quantity'].'</td>';
                           	echo "</tr>";

                        }
                      echo '<tr><td><hr></hr></td><td><hr></hr></td></tr>';
                        echo '<tr><td>Total:</td><td>$'.$carttotal.'</td></tr>';
                        echo '</table>';
                    }

                    ?>
		</div>
		<div class="col-sm-6">
		<?php echo $message; ?>
			<h2>Select payment method:</h2>
			<form role="form" method="post" action="">
			    <div class="radio">
			      <label><input type="radio" name="payment" value="Bank Transfer">Bank Transfer</label>
			    </div>
			    <div class="radio">
			      <label><input type="radio" name="payment" checked="checked" value="Cash on delivery">Cash on delivery</label>
			    </div>
			    <input type="hidden" name="total" value="<?php echo $carttotal; ?>">
			    <input type="submit" value="Confirm Order">
			  </form>
		</div>
	</div>
</div>



<?php require_once('header.php'); ?>


