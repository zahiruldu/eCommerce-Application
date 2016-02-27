<?php

session_start();
require_once('functions.php');

if (isset($_GET['manfilter'])) {
	$manufacture_id = $_GET['manfilter'];
	$manfilter = "AND manufacture='$manufacture_id'";
}else{
	$manfilter = "";
}


if (isset($_GET['catfilter'])) {
	$category_id = $_GET['catfilter'];
	$catfilter="AND category='$category_id'";
}else{
	$catfilter = "";
}

?>

<?php require_once('header.php'); ?>



	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="pull-left">
					<form method="get" action="">
						<select name="catfilter">
							<?php
						    $sql2 ="SELECT * FROM categories";
							$result= $conn->query($sql2);

							if($result){

								while($row = $result->fetch_array()){
									echo "<option value='".$row['cat_id']."'>".$row['cat_name']."</option>";
								}

							}

						    ?>
						</select>
						<input type="submit"  value="filter">
					</form>
				</div>
				<div class="pull-right">

					<form method="get" action="">
						<select name="manfilter">
							<?php
						    $sql3 ="SELECT * FROM manufactures";
							$result= $conn->query($sql3);

							if($result){

								while($row = $result->fetch_array()){
									echo "<option value='".$row['man_id']."'>".$row['man_name']."</option>";
								}

							}

						    ?>
						</select>
						<input type="submit" value="filter">
					</form>
				</div>
				<div class="row">
					<?php 
					$sql = "SELECT * FROM products WHERE status='1' $manfilter $catfilter ";
					$result= $conn->query($sql);
					if($result){
						
						while($row = $result->fetch_array()){

							if(isset($_SESSION['user_id'])){
							    // $add_to ="cart2.php?pid=".$row['pr_id']."&&pr_name=".$row['name']."&&price=".$row['price']."&&qty=1";

							    $add_to = '<form method="post" action="cart.php">
							    	<input type="hidden" name="pid" value="'.$row['pr_id'].'" />
							    	<input type="hidden" name="pr_name" value="'.$row['name'].'" />
							    	<input type="hidden" name="price" value="'.$row['price'].'" />
							    	<input type="hidden" name="qty" value="1" />
							    	<input class="btn btn-default" type="submit" value="Add to Cart" />
							    	</form>';
							}else{
								$add_to ="<a href='login.php' class='btn btn-default' role='button'>Add to Cart</a>";
							}
						
						echo"<div class='col-sm-6 col-md-3'>
							    <div class='thumbnail'>
							      <img src='".$row['image']."' alt=''>
							      <div class='caption'>
							        <h3>".$row['name']."</h3>
							        <p>".$row['description']."</p>
							        <p><a href='' class='btn btn-default' role='button'> $".$row['price']." USD</a>".$add_to."</p>
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