<?php

session_start();

require_once('config.php');

if(isset($_SESSION['user_id']) && $_SESSION['user_type']!=='admin'){
	header('location:index.php');
}

$message = "";

if (isset($_POST['manname'])) {
	$manname = $_POST['manname'];
	$mandesc = $_POST['mandesc'];

	$sql = "INSERT INTO manufactures (man_name,man_description,created_at) VALUES('$manname','$mandesc',NOW())";
	if($conn->query($sql)===TRUE){
        	
	        $message = 'Manufacture has been created successfully!';
	        
        }else{
        	
	        $message = 'Sorry, Please try again!';
        }

}


if(isset($_GET['Mid'])){
	$man_id = $_GET['Mid'];

	$sql3 = "DELETE FROM manufactures WHERE man_id ='$man_id' ";
	if($conn->query($sql3)===TRUE){
		$message = "Manufacture deleted successfully!";
		header( "refresh:1;url=admin_manufacture.php" );
	}else{
		$message = "Sorry, You can not delete this manufacture!";
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
					  <a href="admin_manufacture.php" class="list-group-item active">Manufactures Management</a>
					  <a href="admin_orders.php" class="list-group-item">Orders Mangement</a>
					  
					</div>
				</div>
				<div class="col-sm-8">
					<div class="panel panel-default">
					  <!-- Default panel contents -->
					  <div class="panel-heading">All Menufacturers</div>
					  <div class="panel-body">
					  		<h4><?php echo $message; ?></h4>
					    	<form class="form-inline" role="form" method="post" action="">
							  <div class="form-group">
							    
							    <input type="text" name="manname" class="form-control" id="name" placeholder="Manufacture name" required>
							  </div>
							  <div class="form-group">
							   
							    <textarea name="mandesc" placeholder="Description of manufacture" cols="40"></textarea>
							  </div>
							  
							  <button type="submit" class="btn btn-primary">Create</button>
							</form>
					  </div>

					  <!-- List group -->
					  <ul class="list-group">
					  <?php
					  $sql2 = "SELECT * FROM manufactures";
						$result= $conn->query($sql2);

						if($result){

							while($row = $result->fetch_array()){
								echo "<li class='list-group-item'>".$row['man_name']." <a class='btn btn-default btn-sm glyphicon glyphicon-trash pull-right' href='admin_manufacture.php?Mid=".$row['man_id']."'> Remove</a></li>";
							}

						}
					  ?>
					  </ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





















<?php require_once('header.php'); ?>