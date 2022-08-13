<?php
session_start();

extract($_REQUEST);
include("../connection.php");
$gtotal=array();
$ar=array();
$total=0;
if(isset($_GET['product']))//product id
{
	$product_id=$_GET['product'];
}
else
{
	$product_id="";
}
 if(isset($_SESSION['cust_id']))
 {
 $cust_id=$_SESSION['cust_id'];
 $qq=mysqli_query($con,"select * from tblcustomer where pld_email='$cust_id'");
	 $qqr= mysqli_fetch_array($qq);
 }
if(empty($cust_id))
{
	header("location:index.php?msg=you must login first");
}
if(!empty($product_id && $cust_id ))
{
if(mysqli_query($con,"insert into tblcart (pld_product_id,pld_customer_id) values ('$product_id','$cust_id') "))
{
	echo "success";
	$product_id="";
	header("location:cart.php");
}
else
{
	echo "failed";
}
}
if(isset($del))
{
	if(mysqli_query($con,"delete from tblcart where pld_cart_id='$del' && pld_customer_id='$cust_id'"))
	{
		header("location:cart.php");
	}
	
} 
 if(isset($logout))
 {
	 session_destroy();
	 
	 header("location:../index.php");
 }
 if(isset($login))
 {
	 session_destroy();
	 
	 header("location:index.php");
 }
  $query=mysqli_query($con,"select tbproduct.product,tbproduct.pldvendor_id,tbproduct.cost,tbproduct.description,tbproduct.pldimage,tblcart.pld_cart_id,tblcart.pld_product_id,tblcart.pld_customer_id from tbproduct inner  join tblcart on tbproduct.product_id=tblcart.pld_product_id where tblcart.pld_customer_id='$cust_id'");
  $re=mysqli_num_rows($query);
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cart</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
     
	 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
     <style>
		ul li{list-style:none;}
		ul li a {color:black;text-decoration:none; }
		ul li a:hover {color:black;text-decoration:none; }
		
	 </style>
	 <script>
		  function del(id)
		  {
			  if(confirm('are you sure you want to cancel order')== true)
			  {
				  window.location.href='cart.php?id=' +id;
			  }
		  }
		</script>

</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  
    <a class="navbar-brand" href="../index.php"><span style="color:green;font-family: 'Permanent Marker', cursive;">Roopa Dental Materials</span></a>
    <?php
	if(!empty($cust_id))
	{
	?>
	<a href="profile.php " class="navbar-brand" style="color:black; text-decoratio:none;"><i class="far fa-user"><?php if(isset($cust_id)) { echo $qqr['pld_name']; }?></i></a>
	<?php
	}
	?>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
	
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="../index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../aboutus.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../materials.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../contact.php">Contact</a>
        </li>
		<li class="nav-item">
		  <form method="post">
          <?php
			if(empty($cust_id))
			{
			?>
			<span style="color:black; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:red;" id="cart"  class="badge badge-light">4</span></i></span>
			
			&nbsp;&nbsp;&nbsp;
			<button class="btn btn-outline-danger my-2 my-sm-0" name="login">Log In</button>&nbsp;&nbsp;&nbsp;
            <?php
			}
			else
			{
			?>
			<a href="cart.php"><span style="color:green; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart"  class="badge badge-light"><?php if(isset($re)) echo $re; ?></span></i></span></a>
			<button class="btn btn-outline-success my-2 my-sm-0" name="logout" type="submit">Log Out</button>&nbsp;&nbsp;&nbsp;
			<?php
			}
			?>
			</form>
        </li>
		</ul>
	  </div>
	</nav>

<!--navbar ends-->


<br><br>
<div class="middle" style="  padding:60px; border:1px solid #ED2553;  width:100%;">
       <!--tab heading-->
	   <ul class="nav nav-tabs nabbar_inverse" id="myTab" style="background:#ED2553;border-radius:10px 10px 10px 10px;" role="tablist">
          <li class="nav-item">
             <a class="nav-link active" style="color:#BDDEFD;" id="viewitem-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="viewitem" aria-selected="true">View Cart</a>
          </li>
		  <li class="nav-item">
              <a class="nav-link" style="color:#BDDEFD;" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">Orders</a>
          </li>
		  </ul>
	   <br><br>
	<!--tab 1 starts-->   
	   <div class="tab-content" id="myTabContent">
	   
            <div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab">
                 <table class="table">
                  <tbody>
	               <?php
	                  $query=mysqli_query($con,"select tbproduct.product,tbproduct.pldvendor_id,tbproduct.cost,tbproduct.description,tbproduct.pldimage,tblcart.pld_cart_id,tblcart.pld_product_id,tblcart.pld_customer_id from tbproduct inner  join tblcart on tbproduct.product_id=tblcart.pld_product_id where tblcart.pld_customer_id='$cust_id'");
	                  $re=mysqli_num_rows($query);
	                   if($re)
	                    {
		                 while($res=mysqli_fetch_array($query))
		                  {
			                $vendor_id=$res['pldvendor_id'];
			               $v_query=mysqli_query($con,"select * from tblvendor where pldvendor_id='$vendor_id'");
			               $v_row=mysqli_fetch_array($v_query);
			               $em=$v_row['pld_email'];
			               $nm=$v_row['pld_name'];
	                ?>
                      <tr>
                         <td><image src="../image/supplier/<?php echo $em."/productimages/".$res['pldimage'];?>" height="80px" width="100px"></td>
                         <td><?php echo $res['product'];?></td>
                         <td><?php echo "Euro ".$res['cost'];?></td>
                         <td><?php echo $res['description'];?></td>
                         <td><?php echo $nm; ?></td>
		                <form method="post" enctype="multipart/form-data">
                           <td><button type="submit" name="del"  value="<?php echo $res['pld_cart_id']?>" class="btn btn-danger">Delete</button></td>
                        </form>
                        <td><?php $total=$total+$res['cost']; $gtotal[]=$total;  ?></td>
                      </tr>
					  
					  
                   <?php
	                    }
						?>
						<tr>
					  <td>
					  <h5 style="color:red;">Grand total</h5>
					  </td>
					  <td>
					  <h5><i class="fas fa-euro-sign"></i>&nbsp;<?php echo end($gtotal); ?></h5>
					  </td>
					   <td style="padding:30px; text-align:center;">
					  <a href="order.php?cust_id=<?php echo $cust_id; ?>"><button type="button" style=" color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-warning">Proceed to checkout</button></a>
					  </td>
					  <td></td>
					  </tr>
						<?php
	            } else {
					?>
					 <tr><button type="button" class="btn btn-outline-success"><a href="../materials.php" style="color:green; text-decoration:none;">No Items In cart Let's Shop Now</a></button></tr>
					 <?php
					  }
					 ?>
                 </tbody>
	      </table>	
		  
		  <span style="color:green; text-align:centre;"><?php if(isset($success)) { echo $success; }?></span>
		    </div>	
			 <!--tab starts-->
            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
			    <table class="table">
				<th>Order Number</th>
				<th>Item Name</th>
				<th>Price</th>
				<th>Cancel order</th>
				    <tbody>
					<?php
					$quer_res=mysqli_query($con,"select * from tblorder where pld_email_id='$cust_id' && pldstatus='In Process'");
					while($roww=mysqli_fetch_array($quer_res))
					{   
				         $fid=$roww['pld_product_id'];
				         $qr=mysqli_query($con,"select * from tbproduct where product_id='$fid'");
						 $qrr=mysqli_fetch_array($qr);
						
					  
					?>
					   <tr>
					   <td><?php echo $roww['pld_order_id']; ?></td>
					   <?php
					   if(empty($qrr['product']))
					   {
					   ?>
					   <td><span style="color:red;">Product Not Available Now</span></td>
					   <?php
					   }
					   else
					   {
						   ?>
						    <td><?php echo $qrr['product']; ?></td>
						   <?php
					   }
					   ?>
					  
					   <td><?php echo $qrr['cost']; ?></td>
					   <td><a href="cart.php" onclick="del(<?php echo $roww['pld_order_id'];?>);"><button type="button" class="btn btn-danger">Cancel Order</button></a></td>
					   </tr>
					 <?php
					}
					 ?>  
					</tbody>
				</table>
			</div>
	  </div>
	</div>  
	  
<?php
include("../footer.php");
?>


   
</body>
</html>