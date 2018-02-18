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
		<div class="header">
		      <div style="clear:both"></div>  
        <br />  
		<div class="col-md-2">
        <div class="tableas">  
        <table class="table fixe">  
            <tr>
			<th  class="kk" colspan="3" align="center"><span class="glyphicon glyphicon-shopping-cart">(<?php echo number_format($quant); ?>)</span></th>
			</th><th colspan="2"><h3 class="kartas"><?php echo number_format($total, 2); ?>$</h3></th></tr>
        <tr>  
             <th width="40%">Product Name</th>  
             <th width="10%">Quantity</th>  
             <th width="20%">Price</th>  
             <th width="15%">Total</th>  
             <th width="5%">Action</th>  
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
           <td>
               <a href="index.php?action=delete&id=<?php echo $product['id']; ?>">
                    <div class="btn-danger">Remove</div>
               </a>
           </td>  
        </tr>  
        <?php  
				
             
             endforeach;  
        ?>  
        <tr>  
             <td colspan="3" align="right">Total</td>  
             <td  colspan="2" align="left">$ <?php echo number_format($total, 2); ?></td>  
             <td></td>  
        </tr>  
        <tr>
            <!-- Show checkout button only if the shopping cart is not empty -->
            <td colspan="5">
             <?php 
                if (isset($_SESSION['shopping_cart'])):
                if (count($_SESSION['shopping_cart']) > 0):
             ?>
                <a href="/co.php" class="button co">Checkout</a>
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

        if ($result):
            if(mysqli_num_rows($result)>0):
                while($product = mysqli_fetch_assoc($result)):
                ?>
                <div class="col-sm-6 col-md-4 col-xs-12" >
                    <form method="post" action="index.php?action=add&id=<?php echo $product['id']; ?>">
                        <div class="products">
                            <img src="<?php echo $product['image']; ?>" class="img-responsive" />
                            <h4 class="text-info"><?php echo $product['name']; ?></h4>
                            <h4><b>$ <?php echo $product['price']; ?></b></h4>
							 <h5>$ <?php echo $product['description']; ?></h4>
							<ul class="de">
							<li>RGB: <?php echo $product['rgb']; ?></li>
							<li>DPI: <?php echo $product['dpi']; ?></li>
							<li>Wireless: <?php echo $product['wire']; ?></li>
							<li>Manufacturer: <?php echo $product['manufacturer']; ?></li>																		
							</ul>
							  <input type="number" name="quantity" class="form-control" value="1" />
                            <input type="hidden" name="name" value="<?php echo $product['name']; ?>" />
                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
                            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info"
                                   value="Add to Cart" />
                        </div>
                    </form>
                </div>
                <?php
                endwhile;
            endif;
        endif;   
        ?>

 </div>
        </div>
			<script type="text/javascript" src="jquery.js"></script>
    </body>
</html>
