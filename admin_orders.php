<?php

session_start();
require_once('functions.php');

if(isset($_SESSION['user_id']) && $_SESSION['user_type']!=='admin'){
	header('location:index.php');
}


$message="";

if (isset($_POST['status'])) {
	$status = $_POST['status'];
	$order_id = $_POST['order_id'];

	$sql2 = "UPDATE orders SET status='$status' WHERE order_id='$order_id'";

	if($conn->query($sql2)===TRUE){
		$message = "Order Updated succssfully!";
	}

}


?>

<?php require_once('header.php'); ?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-4">
					<div class="list-group">
					  <a href="admin_products.php" class="list-group-item ">Products Management</a>
					  <a href="admin_categories.php" class="list-group-item ">Category Management</a>
					  <a href="admin_manufacture.php" class="list-group-item">Manufactures Management</a>
					  <a href="admin_orders.php" class="list-group-item active">Orders Mangement</a>
					  
					</div>
				</div>
				<div class="col-sm-8">
					<div class="panel panel-default">
					  <!-- Default panel contents -->
					  <div class="panel-heading">All Orders</div>
					  <div class="panel-body">
					  		<h4><?php echo $message; ?></h4>
					  
					  </div>
					  <!-- list -->
					  <table class="table">
					    <thead>
					      <tr>
					        <th>Order ID</th>
					        <th>Customer ID</th>
					        <th>Total Amount</th>
					        <th>Status</th>
					        <th>Action</th>
					      </tr>
					    </thead>
					    <tbody>
					    <?php

						$sql="SELECT * FROM orders";
						$result= $conn->query($sql);

							if($result){

								while($row = $result->fetch_array()){
									
									echo "<tr>";
									echo "<td>";
									echo $row['order_id'];
									echo "</td>";
									echo "<td>".$row['customer_id']."</td>";
									echo "<td>$".$row['total_amount']."</td>";
									echo "<td>".$row['status']."</td>";
									echo '<td>';
									echo '<form method="post" action="">
									<select name="status">
									<option>ordered</option>
									<option>preparing</option>
									<option>delivered</option>
									<option>canceled</option>
									</select>
									<input type="hidden" name="order_id" value="'.$row['order_id'].'" />
									<input type="submit" value="Update" /></form>';
									echo '</td>';
									echo "</tr>";
								}

							}


					    ?>
					     
					    
					    </tbody>
					  </table>
					  
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





















<?php require_once('header.php'); ?>