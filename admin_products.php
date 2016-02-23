<?php

session_start();

require_once('functions.php');

if(isset($_SESSION['user_id']) && $_SESSION['user_type']!=='admin'){
	header('location:index.php');
}
$message = "";


// Deleting product
if (isset($_GET['Dpid'])) {
	$product_id = $_GET['Dpid'];

	$sql2 = "SELECT * FROM products WHERE pr_id='$product_id'";
	$result= $conn->query($sql2);

		if($result){

			while($row = $result->fetch_array()){
				$img1 = $row['image'];
				$img2 = $row['img2'];
				$img3 = $row['img3'];
				$img4 = $row['img4'];
				$img5 = $row['img5'];

				//Deleting images
				checkAndDeleteItem($img1);
				checkAndDeleteItem($img2);
				checkAndDeleteItem($img3);
				checkAndDeleteItem($img4);
				checkAndDeleteItem($img5);

				$sql3 = "DELETE FROM products WHERE pr_id='$product_id'";
				if($conn->query($sql3)===TRUE){
					$message = "The item has been deleted successfully!";
					header( "refresh:1;url=admin_products.php" );
				}else{
					$message = "Sorry, You can not delete this item!";
				}

			}

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
					  <a href="admin_products.php" class="list-group-item active">Products Management</a>
					  <a href="admin_categories.php" class="list-group-item ">Category Management</a>
					  <a href="admin_manufacture.php" class="list-group-item">Manufactures Management</a>
					  <a href="admin_orders.php" class="list-group-item">Orders Mangement</a>
					  
					</div>
				</div>
				<div class="col-sm-8">
					<div class="panel panel-default">
					  <!-- Default panel contents -->
					  <div class="panel-heading">All Products <a class="btn btn-primary pull-right" href="admin_add_products.php">Add New</a></div>
					  <div class="panel-body">
					  		<h4><?php echo $message; ?></h4>
					  
					  </div>
					  <!-- list -->
					  <table class="table">
					    <thead>
					      <tr>
					        <th>Item</th>
					        <th>Details</th>
					        <th>Status</th>
					        <th>Action</th>
					      </tr>
					    </thead>
					    <tbody>
					    <?php

						$sql="SELECT * FROM products";
						$result= $conn->query($sql);

							if($result){

								while($row = $result->fetch_array()){
									if($row['status']==1){
										$status ="public";
									}else{
										$status = "Private";
									}
									echo "<tr>";
									echo "<td>";
									echo $row['name'];
									echo "<br><img src='".$row['image']."' width='100' height='' />";
									echo "</td>";
									echo "<td>".$row['description']."</td>";
									echo "<td>".$status."</td>";
									echo "<td><a href='admin_products.php?Dpid=".$row['pr_id']."'>Remove</a></td>";
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