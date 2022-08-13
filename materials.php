<?php
session_start();
include("connection.php");
extract($_REQUEST);
$arr=array();

if(isset($_SESSION['cust_id']))
{
	 $cust_id=$_SESSION['cust_id'];
	 $qq=mysqli_query($con,"select * from tblcustomer where pld_email='$cust_id'");
	 $qqr= mysqli_fetch_array($qq);
}
else
{
	$cust_id="";
}
$query=mysqli_query($con,"select  tblvendor.pld_name,tblvendor.pldvendor_id,tblvendor.pld_email,
tblvendor.pld_mob,tblvendor.pld_address,tblvendor.pld_logo,tbproduct.product_id,tbproduct.product,tbproduct.cost,
tbproduct.description,tbproduct.paymentmode 
from tblvendor inner join tbproduct on tblvendor.pldvendor_id=tbproduct.pldvendor_id;");
while($row=mysqli_fetch_array($query))
{
	$arr[]=$row['product_id'];
	shuffle($arr);
}

//print_r($arr);

 if(isset($add))
 {
	 
	if(!empty($_SESSION['cust_id']))
	{
		 $_SESSION['cust_id']=$cust_id;
		header("location:login/cart.php?product=$add");
	}
	else
	{
		header("location:login/?product=$add");
	}
 }
 
 if(isset($login))
 {
	 header("location:login/index.php");
 }
 if(isset($logout))
 {
	 session_destroy();
	 header("location:index.php");
 }
 $query=mysqli_query($con,"select tbproduct.product,tbproduct.pldvendor_id,tbproduct.cost,tbproduct.description,tbproduct.pldimage,tblcart.pld_cart_id,tblcart.pld_product_id,tblcart.pld_customer_id from tbproduct inner  join tblcart on tbproduct.product_id=tblcart.pld_product_id where tblcart.pld_customer_id='$cust_id'");
  $re=mysqli_num_rows($query);
?>
<html>
  <head>
     <title>Products</title>
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
     
	 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	 <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Permanent+Marker" rel="stylesheet">
    
	 <style>
	 .carousel-item {
  height: 100vh;
  min-height: 350px;
  background: no-repeat center center scroll;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
	 </style>
<style>
ul li {list-style:none;}
ul li a{color:black; font-weight:bold;}
ul li a:hover{text-decoration:none;}
</style>
  </head>
  <body>
<div id="result" style="position:fixed;top:100; right:50;z-index: 3000;width:350px;background:white;"></div>
<!--navbar start-->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  
    <a class="navbar-brand" href="index.php"><span style="color:green;font-family: 'Permanent Marker', cursive;">Roopa Dental materials</span></a>
    <?php
	if(!empty($cust_id))
	{
	?>
	<a href="login/profile.php" class="navbar-brand" style="color:black; text-decoratio:none;"><i class="far fa-user"><?php if(isset($cust_id)) { echo $qqr['pld_name']; }?></i></a>
	<?php
	}
	?>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
	
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="aboutus.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="materials.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
		<li class="nav-item">
		  <form method="post">
          <?php
			if(empty($cust_id))
			{
			?>
			<a href="login/index.php?msg=you must be login first"><span style="color:red; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:red;" id="cart"  class="badge badge-light">0</span></i></span></a>
			
			&nbsp;&nbsp;&nbsp;
			<button class="btn btn-outline-danger my-2 my-sm-0" name="login" type="submit">Log In</button>&nbsp;&nbsp;&nbsp;
            <?php
			}
			else
			{
			?>
			<a href="login/cart.php"><span style=" color:green; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart"  class="badge badge-light"><?php if(isset($re)) { echo $re; }?></span></i></span></a>
			<button class="btn btn-outline-success my-2 my-sm-0" name="logout" type="submit">Log Out</button>&nbsp;&nbsp;&nbsp;
			<?php
			}
			?>
			</form>
        </li>
		<li class="nav-item">
		
		  
		</li>
      </ul>
	  
    </div>
	
</nav>
<!--navbar ends-->
<div>
<img class="d-block w-100" src="img/shop.jpg" alt="shopping">
</div>
<div class="tab-content" id="myTabContent">
	   
	   <div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="viewitem-tab">
			<div class="container">
			  <table class="table">
			<thead>
			   <tr>
				   <th scope="col">Material_Id</th>
					   <th scope="col">product View</th>
					   <th scope="col">Description</th>
					   <th scope="col">Reprsentative Name</th>
					   <th scope="col">product Id</th>
					   <th scope="col">Add to cart</th>
				</tr>
			</thead>
			<tbody>
<?php
$query=mysqli_query($con,"select tblvendor.pldvendor_id,tblvendor.pld_name,tblvendor.pld_email,tbproduct.product_id,tbproduct.product,tbproduct.description,tbproduct.pldimage from  tblvendor right join tbproduct on tblvendor.pldvendor_id=tbproduct.pldvendor_id");
   while($row=mysqli_fetch_array($query))
   {
?>			 
		   <tr>
				   <th scope="row"><?php echo $row['pldvendor_id'];?></th>
				   <td><img src="image/supplier/<?php echo $row['pld_email']."/productimages/" .$row['pldimage'];?>" height="50px" width="100px">
				   <br><?php echo $row['product'];?>
				   </td>
				   <td><?php echo $row['description'];?></td>
				   <td><?php echo $row['pld_name'];?></td>
				   <td><?php echo $row['product_id'];?></td>
				  <form method="post">
				   <td><a href="login/cart.php"><button type="submit" value="<?php echo $row['product_id']; ?>" name="add"  class="btn btn-danger">Add to cart</button></td>
				   </form>
			  </tr>
   <?php
   }
   ?>		   
		   </tbody>
	  </table>

</div>   	
	 <span style="color:green; text-align:centre;"><?php if(isset($success)) { echo $success; }?></span>
	   </div>	
 <?php
			include("footer.php");
			?>


	</body>
</html>