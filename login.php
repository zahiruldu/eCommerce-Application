<?php

session_start();

require_once('config.php');

$message=$email=$pass="";

if (isset($_POST['email'])) {
	
	$email = $_POST['email'];
    $pass = md5($_POST['pass']);

    $sql = "SELECT * FROM users WHERE email='$email' AND pass='$pass'";

     $result= $conn->query($sql);

     if(mysqli_num_rows($result) == 0) {
		     $message = "Your email or password is incorrect!";

		     
		} else {
		    $message = "Login success!";

		    while($row=mysqli_fetch_array($result)){
		    	$user_id =$row['id'];
		    	$user_type =$row['user_type'];

		    	 // Making the session
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_type'] = $user_type;

                 header( "refresh:2;url=index.php" );

		    }
		}
}






?>

<?php require_once('header.php'); ?>

<div class="container">
	<div class="row">
	<?php echo $message; ?>
		<form role="form" method="post" action="">
		  <div class="form-group">
		    <label for="email">Email address:</label>
		    <input type="email" name="email" class="form-control" id="email">
		  </div>
		  <div class="form-group">
		    <label for="pwd">Password:</label>
		    <input type="password" name="pass" class="form-control" id="pwd">
		  </div>
		  
		  <button type="submit" class="btn btn-default">Login</button>
		</form>
		<p>Don't have an account? <a href="register.php">Create Account</a></p>
	</div>
</div>



<?php require_once('footer.php'); ?>
