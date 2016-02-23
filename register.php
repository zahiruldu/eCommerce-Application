<?php

session_start();

require_once('config.php');

$message=$name=$address=$mobile=$email=$pass="";

if (isset($_POST['email'])) {
	
	$name = $_POST['name'];
	$address = $_POST['address'];
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
    $pass = md5($_POST['pass']);

    $sql = "INSERT INTO users (name,address,mobile,email,pass,created_at) 
    		VALUES('$name','$address','$mobile','$email','$pass',NOW())";

    if($conn->query($sql)===TRUE){
        	$last_id = $conn->insert_id;
        	
	        $message = 'Thanks! You have registered successfully!';
	        
                // Making the session
                $_SESSION['user_id'] = $last_id;
                $_SESSION['user_type'] = "customer";

                header( "refresh:2;url=index.php" );
               
        }else{
        	
	        $message = 'Sorry, Please try again!';
        }

}






?>

<?php require_once('header.php'); ?>

<div class="container">
	<div class="row">

	<?php echo $message; ?>

		<form role="form" method="post" action="">
		  <div class="form-group">
		    <label for="name">Name:</label>
		    <input type="text" name="name" class="form-control" id="name">
		  </div>
		  <div class="form-group">
		    <label for="email">Email address:</label>
		    <input type="email" name="email" class="form-control" id="email" required>
		  </div>
		  <div class="form-group">
		    <label for="address">Address:</label>
		   
		    <textarea  name="address" class="form-control"></textarea>
		  </div>
		  <div class="form-group">
		    <label for="tel">Contact number:</label>
		    <input type="tel" name="mobile" class="form-control" id="mobile">
		  </div>
		  <div class="form-group">
		    <label for="pwd">Password:</label>
		    <input type="password" name="pass" class="form-control" id="pwd" required>
		  </div>
		  
		  <button type="submit" class="btn btn-default">Register</button>
		</form>
		<p>Already registered? <a href="login.php">Login here</a></p>
	</div>
</div>


<?php require_once('footer.php'); ?>