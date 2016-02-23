<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Simple Ecommerce</a>
    </div>
    <ul class="nav navbar-nav avbar-left">
      <li class="active"><a href="index.php">Home</a></li>
      <li><a href="#">Products</a></li>

      
    </ul>
    <ul class="nav navbar-nav navbar-right">
    <?php

      
     if (isset($_SESSION['cart_array'])) {
       $cart_count=count($_SESSION['cart_array']); 
     }else{
      $cart_count ="0";
     }

     ?>
      <li><a href="cart.php" class="glyphicon glyphicon-shopping-cart"> Cart 
      <span class="badge" id="comparison-count">
    <?php echo $cart_count; ?> 
      </span></a>
      </li>

    <?php if (!empty($_SESSION['user_id']) && $_SESSION['user_type'] ==='admin') { ?>
    <li><a href="admin.php">Dashboard</a></li> 
    <?php } ?>

    
      <?php if (!empty($_SESSION['user_id'])) { ?>

      <li><a href="logout.php">Logout</a></li> 
      <?php } else{?>
      <li><a href="login.php">Login</a></li> 
      <li><a href="register.php">Register</a></li> 
      <?php } ?>

    </ul>
  </div>
</nav>