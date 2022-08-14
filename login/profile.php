<?php
session_start();
extract($_REQUEST);
include("../connection.php");
if (isset($_SESSION['cust_id'])) {
  $cust_id = $_SESSION['cust_id'];
  $qq = mysqli_query($con, "select * from tblcustomer where pld_email='$cust_id'");
  $qqr = mysqli_fetch_array($qq);
}
if (isset($logout)) {
  session_destroy();
  header("location:../index.php");
}
if (isset($login)) {
  session_destroy();
  header("location:index.php");
}
//update section
$cust_details = mysqli_query($con, "select * from tblcustomer where pld_email='$cust_id'");
$row_cust = mysqli_fetch_array($cust_details);
$pld_name = $row_cust['pld_name'];
$pld_email = $row_cust['pld_email'];
$pld_mobile = $row_cust['pld_mobile'];
$pld_password = $row_cust['password'];
if (isset($update)) {
  if (mysqli_query($con, "update tblcustomer set pld_name='$name',pld_mobile='$mobile',password='$pswd' where pld_email='$pld_email'")) {
    header("location:../index.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile</title>
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
    ul li {
      list-style: none;
    }
    ul li a {
      color: black;
      font-weight: bold;
    }
    ul li a:hover {
      text-decoration: none;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="../index.php"><span style="color:green;font-family: 'Permanent Marker', cursive;">Roopa Dental Materials</span></a>
    <?php
    if (!empty($cust_id)) {
    ?>
      <a href="profile.php" class="navbar-brand" style="color:black; text-decoratio:none;"><i class="far fa-user"><?php if (isset($cust_id)) {
                                                                                                                    echo $qqr['pld_name'];
                                                                                                                  } ?></i></a>
    <?php
    }
    ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="../index.php">Home </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../aboutus.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../services.php">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <form method="post">
            <?php
            if (empty($cust_id)) {
            ?>
              <span style="color:black; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:red;" id="cart" class="badge badge-light">4</span></i></span>
              &nbsp;&nbsp;&nbsp;
              <button class="btn btn-outline-danger my-2 my-sm-0" name="login">Log In</button>&nbsp;&nbsp;&nbsp;
            <?php
            } else {
            ?>
              <a href="cart.php"><span style="color:green; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart" class="badge badge-light"><?php if (isset($re)) echo $re; ?></span></i></span></a>
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
        <a class="nav-link" style="color:#BDDEFD;" id="manageaccount-tab" data-toggle="tab" href="#manageaccount" role="tab" aria-controls="manageaccount" aria-selected="false">Account Settings</a>
      </li>
    </ul>
    <br><br>
    <!--tab starts-->
    <div class="tab-pane fade" id="manageaccount" role="tabpanel" aria-labelledby="manageaccount-tab">
      <form method="post">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" id="name" value="<?php if (isset($pld_name)) {
                                                echo $pld_name;
                                              } ?>" class="form-control" name="name" required="required" />
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?php if (isset($pld_email)) {
                                                                echo $pld_email;
                                                              } ?>" class="form-control" readonly />
        </div>
        <div class="form-group">
          <label for="mobile">Mobile</label>
          <input type="tel" id="mobile" class="form-control" name="mobile" pattern="[0-9]{10}" value="<?php if (isset($pld_mobile)) {
                                                                                                        echo $pld_mobile;
                                                                                                      } ?>" required>
        </div>
        <div class="form-group">
          <label for="pwd">Password:</label>
          <input type="password" name="pswd" value="<?php if (isset($pld_password)) {
                                                      echo $pld_password;
                                                    } ?>" class="form-control" id="pwd" required />
        </div>
        <button type="submit" name="update" style="background:#ED2553; border:1px solid #ED2553;" class="btn btn-primary">Update</button>
        <div class="footer" style="color:red;"><?php if (isset($ermsg)) {
                                                  echo $ermsg;
                                                } ?><?php if (isset($ermsg2)) {
                                                                                            echo $ermsg2;
                                                                                          } ?></div>
      </form>
    </div>
    <!--tab ends-->
  </div>
  </div>
  <?php
  include("../footer.php");
  ?>
</body>
</html>