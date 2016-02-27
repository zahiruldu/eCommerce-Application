<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Simple Ecommerce</a>
    </div>
    <ul class="nav navbar-nav avbar-left">
      <li class="active"><a href="index.php">Home</a></li>
      

      
    </ul>
    <ul class="nav navbar-nav navbar-right">
  
      <li><a href="cart.php" class="glyphicon glyphicon-shopping-cart"> Cart 
      <span class="badge" id="comparison-count">
    <?php 
    if(!empty($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
      $sql = "SELECT COUNT(id) FROM cart WHERE user_id='$user_id' AND status='cart'";
        $result= $conn->query($sql);
        if ($result) {
          while($row = $result->fetch_array()){
            echo $row["COUNT(id)"];
          }
        }
    }else{
      echo "0";
    }


     ?> 
      </span></a>
      </li>

    <?php if (!empty($_SESSION['user_id']) && $_SESSION['user_type'] ==='admin') { ?>
    <li><a href="admin.php">Dashboard</a></li> 
    <?php } ?>

    
      <?php if (!empty($_SESSION['user_id'])) { ?>
      <li><a href="myorders.php">Account</a></li> 
      <li><a href="logout.php">Logout</a></li> 
      <?php } else{?>
      <li><a href="login.php">Login</a></li> 
      <li><a href="register.php">Register</a></li> 
      <?php } ?>

    </ul>
  </div>
</nav>