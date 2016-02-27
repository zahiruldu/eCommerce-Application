<?php

session_start();
require_once('functions.php');

if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
}


$message="";




?>

<?php require_once('header.php'); ?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				
				<div class="col-sm-12">
					<div class="panel panel-default">
					  <!-- Default panel contents -->
					  <div class="panel-heading">My Orders</div>
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
					        
					      </tr>
					    </thead>
					    <tbody>
					    <?php

						$sql="SELECT * FROM orders WHERE customer_id='$user_id'";
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