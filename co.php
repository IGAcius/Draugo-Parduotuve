<?php
session_start();
$product_ids = array();
/// session_destroy();
if(filter_input(INPUT_POST, 'add_to_cart')){
    if(isset($_SESSION['shopping_cart'])){
        
        $count = count($_SESSION['shopping_cart']);
        
        $product_ids = array_column($_SESSION['shopping_cart'], 'id');
        
        if (!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
        $_SESSION['shopping_cart'][$count] = array
            (
                'id' => filter_input(INPUT_GET, 'id'),
                'name' => filter_input(INPUT_POST, 'name'),
                'price' => filter_input(INPUT_POST, 'price'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
            );   
        }
        else { 
            for ($i = 0; $i < count($product_ids); $i++){
                if ($product_ids[$i] == filter_input(INPUT_GET, 'id')){
                    $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                }
            }
        }
        
    }
    else { 
        $_SESSION['shopping_cart'][0] = array
        (
            'id' => filter_input(INPUT_GET, 'id'),
            'name' => filter_input(INPUT_POST, 'name'),
            'price' => filter_input(INPUT_POST, 'price'),
            'quantity' => filter_input(INPUT_POST, 'quantity')
        );
    }
}

if(filter_input(INPUT_GET, 'action') == 'delete'){
    foreach($_SESSION['shopping_cart'] as $key => $product) {
        if ($product['id'] == filter_input(INPUT_GET, 'id')){
            unset($_SESSION['shopping_cart'][$key]);
        }
    }
    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}
$total = 0;
$quant = 0;
  if(!empty($_SESSION['shopping_cart'])):  
            
        
             foreach($_SESSION['shopping_cart'] as $key => $product): 
			    $total = $total + ($product['quantity'] * $product['price']);  
				$quant = $quant + $product['quantity'];
             endforeach;  
			 endif;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Shopping Cart (working)</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link rel="stylesheet" href="styles.css" />
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    </head>
	<header>
		<div class="header2">
		      <div style="clear:both"></div>  
        <br />  
		<div class="col-md-12">
        <div class="tableass">  
        <table class="table fixe">  
            <tr>
			<th class="kkz" colspan="4" align="left">My Order</span></th>
        <tr>  
             <th width="40%">Product Name</th>  
             <th width="10%">Quantity</th>  
             <th width="20%">Price</th>  
             <th width="20%">Total</th>  
        </tr>  
        <?php   
        if(!empty($_SESSION['shopping_cart'])):  
            
        
             foreach($_SESSION['shopping_cart'] as $key => $product): 
        ?>  
        <tr>  
           <td><?php echo $product['name']; ?></td>  
           <td><?php echo $product['quantity']; ?></td>  
           <td>$ <?php echo $product['price']; ?></td>  
           <td>$ <?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>  
   
           </td>  
        </tr>  
        <?php  
				
             
             endforeach;  
        ?>  
        <tr>  
             <td colspan="3" align="right">Total</td>  
             <td colspan="2" align="left">$ <?php echo number_format($total, 2); ?></td>  
             <td></td>  
        </tr>  
        <tr>
            <!-- Show checkout button only if the shopping cart is not empty -->
			  <td colspan="2">
			  <a class="bb" href="/index.php">Back to shop...</a>
			  </td>
		   <td colspan="2">
             <?php 
                if (isset($_SESSION['shopping_cart'])):
                if (count($_SESSION['shopping_cart']) > 0):
             ?>
                <a href="/co.php" class="button pp">Checkout</a>
             <?php endif; endif; ?>
            </td>
        </tr>
        <?php  
        endif;
        ?>  
        </table>  
         </div>
		</div>
		</div>
		</div>
	</header>
    <body>
        <div class="container">
        <?php

        $connect = mysqli_connect('localhost', 'juemis_root', 'Lopas113', 'juemis_ignas');
        $query = 'SELECT * FROM products ORDER by id ASC';
        $result = mysqli_query($connect, $query);

   ?>
        </div>
			<script type="text/javascript" src="jquery.js"></script>
    </body>
</html>
