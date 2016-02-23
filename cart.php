<?php

session_start();
require_once('functions.php');

    if (isset($_GET['pid'])) {
        
        $pid = $_GET['pid'];
        $wasFound = false;
        $i = 0;

        if(!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1){

            $_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));

        }else{

            foreach ($_SESSION["cart_array"] as $each_item) {
                $i++;
                while(list($key, $value) = each($each_item)){
                    if($key == "item_id" && $value == $pid){
                        array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
                        $wasFound = true;
                    }

                }
            }

            if($wasFound == false){
                array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
            }

        }

        header("location: cart.php"); 
        exit();
    }


 // Emtpy the shopping cart
    if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
    }


// Quantity Changes
    if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
    // execute some code
    $item_to_adjust = $_POST['item_to_adjust'];
    $quantity = $_POST['quantity'];
    $quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
    if ($quantity >= 100) { $quantity = 99; }
    if ($quantity < 1) { $quantity = 1; }
    if ($quantity == "") { $quantity = 1; }
    $i = 0;
    foreach ($_SESSION["cart_array"] as $each_item) { 
              $i++;
              while (list($key, $value) = each($each_item)) {
                  if ($key == "item_id" && $value == $item_to_adjust) {
                      // That item is in cart already so let's adjust its quantity using array_splice()
                      array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
                  } // close if condition
              } // close while loop
        } // close foreach loop
    }



// Removing single item from cart
    if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
    // Access the array and run code to remove that array index
    $key_to_remove = $_POST['index_to_remove'];
    if (count($_SESSION["cart_array"]) <= 1) {
        unset($_SESSION["cart_array"]);
    } else {
        unset($_SESSION["cart_array"]["$key_to_remove"]);
        sort($_SESSION["cart_array"]);
        }
    }
?>

<?php 
 // Displaying the shopping cart
$cartOutput = "";
$cartTotal = "";
$checkout_btn = '';
$product_id_array = '';

if(!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1){
    $cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
}else{
    $checkout_btn .= '<form action="checkout.php" method="post">';
  


    $i = 0; 

    foreach ($_SESSION["cart_array"] as $each_item) {
        $item_id = $each_item['item_id'];
        $result =$conn->query("SELECT * FROM products WHERE pr_id='$item_id' LIMIT 1");
        if($result){
            while($row = $result->fetch_array()){
                $product_name = $row['name'];
                $image        = $row['image'];
                $price     = $row['price'];
                $details   = $row['description'];
            }

            $pricetotal = $price * $each_item['quantity'];
            $cartTotal = $pricetotal + $cartTotal;
        }

        // Dynamic Checkout Btn Assembly
        $x = $i + 1;
        $checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '">
        <input type="hidden" name="amount_' . $x . '" value="' . $price . '">
        <input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">  ';
        // Create the product array variable
        $product_id_array .= "$item_id-".$each_item['quantity'].","; 
        // Dynamic table row assembly
        $cartOutput .= "<tr>";
        $cartOutput .= '<td>' . $product_name . '<br /><img src="'.$image.'" alt="' . $product_name. '" width="40" height="52" border="1" /></td>';
        $cartOutput .= '<td>' . $details . '</td>';
        $cartOutput .= '<td>$' . $price . '</td>';
        $cartOutput .= '<td><form action="cart.php" method="post">
        <input name="quantity" type="text" value="' . $each_item['quantity'] . '" size="1" maxlength="2" />
        <input name="adjustBtn' . $item_id . '" type="submit" value="change" />
        <input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
        </form></td>';
        //$cartOutput .= '<td>' . $each_item['quantity'] . '</td>';
        $cartOutput .= '<td>' . $pricetotal . '</td>';
        $cartOutput .= '<td><form action="cart.php" method="post"><input name="deleteBtn' . $item_id . '" type="submit" value="X" /><input name="index_to_remove" type="hidden" value="' . $i . '" /></form></td>';
        $cartOutput .= '</tr>';
        $i++;
    }

    $cartTotal = "<div style='font-size:18px; margin-top:12px;' align='right'>Cart Total : ".$cartTotal." USD</div>";
    // Finish the Paypal Checkout Btn
    $checkout_btn .= '<input type="hidden" name="items" value="' . $product_id_array . '">
    
    <input type="submit" name="checkout" value="Checkout">

   
    </form>';
}


?>

<?php require_once('header.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Detail</th>
                            <th>Unit Price</th>
                            <th>Qnty</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $cartOutput; ?>
                    </tbody>

                </table>
                <?php echo $checkout_btn; ?>


                <?php echo $cartTotal; ?>
                <a class=" btn btn-warning pull-left" href="cart.php?cmd=emptycart">Click Here to Empty Your Shopping Cart</a>
            </div>
        </div>
    </div>




<?php require_once('footer.php'); ?>






