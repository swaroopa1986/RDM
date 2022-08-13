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
 //to fetch all the details of the vendor and products supplied
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

 if(isset($addtocart))
 {
	 
	if(!empty($_SESSION['cust_id']))
	{
		 $_SESSION['cust_id']=$cust_id;
		header("location:login/cart.php?product=$addtocart");
	}
	else
	{
		header("location:login/?product=$addtocart");
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
 
 if(isset($message))
 {
	 echo $name;
	 echo $msgtxt;
	 echo $email;
	 echo $phone;
	 if(mysqli_query($con,"insert into tblmessage(pld_name,pld_email,pld_phone,pld_msg) values ('$name','$email','$phone','$msgtxt')"))
     {
		 echo "<script> alert('We will be Connecting You shortly')</script>";
	 }
	 else
	 {
		 echo "failed";
	 }
}$query=mysqli_query($con,"select tbproduct.product,tbproduct.pldvendor_id,tbproduct.cost,tbproduct.description,tbproduct.pldimage,tblcart.pld_cart_id,tblcart.pld_product_id,tblcart.pld_customer_id from tbproduct inner  join tblcart on tbproduct.product_id=tblcart.pld_product_id where tblcart.pld_customer_id='$cust_id'");
  $re=mysqli_num_rows($query);
?>
<html>
  <head>
     <title>Contact-us</title>
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
     <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
	 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	 <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Permanent+Marker" rel="stylesheet">

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
  
    <a class="navbar-brand" href="index.php"><span style="color:green;font-family: 'Permanent Marker', cursive;">Roopa Dental Materials</span></a>
    <?php
	if(!empty($cust_id))
	{
	?>
	<a href="login/profile.php" class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user"><?php if(isset($cust_id)) { echo $qqr['pld_name']; }?></i></a>
	<?php
	}
	?>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
	
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home </a>
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
		
      </ul>
	  
    </div>
	
</nav>
<!--navbar ends-->

<br><br><br>
<div class="container-fluid">
  <img src="img/contact.jpg" width="100%" height="500px">
</div>
<br>
<div class="container">
  <div class="row">
    <div class="col-sm-8" style="padding:20px; border:1px solid #F0F0F0;">
	    <form method="post">
            <div class="form-group">
                 <input type="text" class="form-control"  placeholder="Name*" name="name" required/>
            </div>
			<div class="form-group">
                 <input type="email" class="form-control"  placeholder="email*" value="<?php if(isset($cust_id)) echo $cust_id; ?>" name="email" required/>
            </div>
			<div class="form-group">
                 <input type="tel" class="form-control" pattern="[0-9]{10}"  name="phone" placeholder="Phone(optinal)"/>
            </div>
			<div class="form-group">
                <textarea class="form-control"    placeholder="Message*" name="msgtxt" rows="3" col="10" required></textarea>
            </div>
			<div class="form-group">
                   <button type="submit" name="message" class="btn btn-danger">Send Message</button>
            </div>
        </form>
	</div>
    <div class="col-sm-4" style="padding:30px;">
	   <div class="form-group">
           <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;<b>01-23654789</b><br><br>
			<i class="fa fa-home" aria-hidden="true"></i>&nbsp; 23-A ,North-East Campus,Dublin Road, Dublin EirCode-D01FG34<br>(24*7 Days)
	       
	   </div>
	</div>
  </div>
</div>
<br><br>
  <?php
			include("footer.php");
			?>





	</body>
</html>