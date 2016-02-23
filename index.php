<?php

session_start();
require_once('functions.php');



?>

<?php require_once('header.php'); ?>



	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<?php 
					$sql = "SELECT * FROM products WHERE status='1'";
					$result= $conn->query($sql);
					if($result){
						
						while($row = $result->fetch_array()){

							if(isset($_SESSION['user_id'])){
							    $add_to ="cart.php?pid=".$row['pr_id'];
							}else{
								$add_to ="login.php";
							}
						
						echo"<div class='col-sm-6 col-md-3'>
							    <div class='thumbnail'>
							      <img src='".$row['image']."' alt=''>
							      <div class='caption'>
							        <h3>".$row['name']."</h3>
							        <p>".$row['description']."</p>
							        <p><a href='' class='btn btn-default' role='button'> $".$row['price']." USD</a> <a href='".$add_to."' class='btn btn-default' role='button'>Add to Cart</a></p>
							      </div>
							    </div>
							  </div> ";
						}

					}

					?>
					
				</div>
			</div>
		</div>
	</div>



















<?php require_once('header.php'); ?>