<?php
session_start();
include("connection.php");
extract($_REQUEST);
if(isset($_SESSION['id']))
{
	header("location:product.php");
}
  if(isset($login))
  {
	$sql=mysqli_query($con,"select * from tblvendor where pld_email='$email' && pld_password='$pswd' ");
    if(mysqli_num_rows($sql))
	{
	 $_SESSION['id']=$email;
	header('location:product.php');	
	}
	else
	{
	$admin_login_error="Invalid Username or Password";	
	}
  }
  if(isset($register))
  {
$sql=mysqli_query($con,"select * from tblvendor where pld_email='$email'");
 if(mysqli_num_rows($sql))
{
 $email_error="This Email Id is laready registered with us";
}
else
{
$logo=$_FILES['logo']['name'];
$sql=mysqli_query($con,"insert into tblvendor 
(pld_name	,pld_email,pld_password,pld_mob,pld_phone,pld_address,pld_logo)
      values('$r_name','$email','$pswd','$mob','$phone','$address','$logo')");

 if($sql)
{
mkdir("image/supplier");
mkdir("image/supplier/$email");

move_uploaded_file($_FILES['logo']['tmp_name'],"image/supplier/$email/".$_FILES['logo']['name']);
}
$_SESSION['id']=$email;

header("location:product.php");

}
}  
?>

<head>
  <meta charset="UTF-8">
    <title>Vendor Login</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		
		<style>
		ul li{}
		ul li a {color:white;padding:40px; }
		ul li a:hover {color:white;}
		</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  
    <a class="navbar-brand" href="index.php"><span style="color:green;font-family: 'Permanent Marker', cursive;">Roopa Dental Materials</span></a>
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
</ul>
</div>
</nav>
<div class="middle" style="position:relative; padding:40px; border:1px solid #ED2553; left:30%; top:10%; width:500px;">
       <ul class="nav nav-tabs navbar_inverse" id="myTab" style="background:#ED2553;border-radius:10px 10px 10px 10px;" role="tablist">
          <li class="nav-item">
             <a class="nav-link active" id="home-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true">Supplier Login</a>
          </li>
         <li class="nav-item">
              <a class="nav-link" id="signup-tab" style="color:#BDDEFD;" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Create New Account</a>
          </li>
        </ul>
	   <br><br>
	   <div class="tab-content" id="myTabContent">
	   <!--login Section-- starts-->
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
			    <div class="footer" style="color:red;"><?php if(isset($admin_login_error)){ echo $admin_login_error;}?></div>
			  <form action="" method="post">
                        <div class="form-group">
                           <label for="email">Email:</label>
                           <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required/>
                        </div>
                        <div class="form-group">
                             <label for="pwd">Password:</label>
                             <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required/>
                        </div>
                        
                          <button type="submit" name="login" class="btn btn-primary">Submit</button>
                 </form>
			</div>
			<!--login Section-- ends-->
      <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="profile-tab">
			    <div class="footer" style="color:red;"><?php if(isset($loginmsg)){ echo $loginmsg;}?></div>
			    <form action="" method="post">
                      <div class="form-group">
                          <label for="name">Name:</label>
                          <input type="text" class="form-control" id="name" value="<?php if(isset($r_name)) { echo $r_name;}?>" placeholder="Enter supplier Name" name="r_name" required/>
                      </div>
	                  <div class="form-group">
                          <label for="name">Email Id:</label>
                          <input type="email" class="form-control" id="email" value="<?php if(isset($email)) { echo $email;}?>" placeholder="Enter Email" name="email" required/>
                          <span style="color:red;"><?php if(isset($email_error)){ echo $email_error;} ?></span>
	                  </div>
	                 <div class="form-group">
                         <label for="pswd">Password:</label>
                         <input type="password" class="form-control" id="pswd" placeholder="Enter Password" name="pswd" required/>
                     </div>
                     <div class="form-group">
                         <label for="mob">Mobile:</label>
                         <input type="tel" class="form-control" pattern="[0-9]{10}" value="<?php if(isset($mob)) { echo $mob;}?>"id="mob" placeholder="9123456578" name="mob" required/>
                     </div>
	                 <div class="form-group">
                          <label for="phone">Phone:</label>
                          <input type="tel" class="form-control" pattern="[0-9]{10}" id="phone" value="<?php if(isset($phone)) { echo $phone;}?>" placeholder="01-12345678" name="phone" required>
                     </div>
	                 <div class="form-group">
                          <label for="add">Address:</label>
                          <input type="text" class="form-control" id="add" placeholder="Enter Address" value="<?php if(isset($address)) { echo $address;}?>" name="address" required>
                     </div>
	                 <div class="form-group">
                          <input type="file"  name="logo" required>Upload Logo 
                     </div>
                     <button type="submit" id="register" name="register" class="btn btn-outline-primary">Register</button>
                     
                </form>
				<br>
			</div>
			</div>
	  </div>
    <br><br> <br><br> <br><br>
	  <?php
			include("footer.php");
			?> 
</body>
