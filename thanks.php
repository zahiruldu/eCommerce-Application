<?php

session_start();
require_once('functions.php');

$user_id = $_SESSION['user_id'];
$carttotal = $message = "";

if (isset($_GET['sms'])) {
	$message = "You have placed order successfully!";
}


?>
<?php require_once('header.php'); ?>

<div class="container">
	<div class="row">
		<h1><?php echo $message; ?></h1>
	</div>
</div>



<?php require_once('header.php'); ?>


