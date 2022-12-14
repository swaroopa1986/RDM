<?php
session_start();
include("connection.php");
extract($_REQUEST);
if (!isset($_SESSION['admin'])) {
	header("location:admin.php");
} else {
	$admin_username = $_SESSION['admin'];
}
if (isset($logout)) {
	unset($_SESSION['admin']);
	setcookie('logout', 'loggedout successfully', time() + 5);
	header("location:admin.php");
}
if (isset($delete)) {
	header("location:dashboard.php?id=$delete");
}
if (isset($deleteVendor)) {
	header("location:dashboard.php?Vendorid=$deleteVendor");
}
$admin_info = mysqli_query($con, "select * from tbadmin where pld_username='$admin_username'");
$row_admin = mysqli_fetch_array($admin_info);
$user = $row_admin['pld_username'];
$pass = $row_admin['pldpassword'];
//update
if (isset($update)) {
	if (mysqli_query($con, "update tbadmin set pldpassword='$password'")) {
		unset($_SESSION['admin']);
		header("location:admin_info_update.php");
	} else {
		echo "failed";
	}
}
?>
<html>
<head>
	<title>Admin control panel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<style>
		ul li {}
		ul li a {
			color: black;
		}
		ul li a:hover {
			color: black;
			font-weight: bold;
		}
		ul li {
			list-style: none;
		}
		ul li a:hover {
			text-decoration: none;
		}
		#social-fb,
		#social-tw,
		#social-gp,
		#social-em {
			color: blue;
		}
		#social-fb:hover {
			color: #4267B2;
		}
		#social-tw:hover {
			color: #1DA1F2;
		}
		#social-gp:hover {
			color: #D0463B;
		}
		#social-em:hover {
			color: #D0463B;
		}
	</style>
	<script>
		function delRecord(id) {
			var x = confirm("You want to delete this record? All product Items Of that Vendor Will Also Be Deleted");
			if (x == true) {
				window.location.href = 'dashboard.php?Vendorid=' + id;
			} else {
				window.location.href = 'index.php';
			}
		}
	</script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
		<a class="navbar-brand" href="index.php"><span style="color:green;font-family: 'Permanent Marker', cursive;">Roopa Dental Materials</span></a>
		<?php
		if (!empty($admin_username)) {
		?>
			<a href="profile.php" class="navbar-brand" style="color:black; text-decoration:none;"><i class="far fa-user">Admin</i></a>
		<?php
		}
		?>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
				<?php
				if (isset($_SESSION['admin'])) {
				?>
					<li class="nav-item">
						<a class="nav-link" href="">
							<form method="post">
								<button type="submit" name="logout" class="btn btn-outline-success">Log Out</button>
							</form>
						</a>
					</li>
				<?php
				}
				?>
			</ul>
		</div>
	</nav>
	<!--navbar ends-->
	<br><br><br><br>
	<div class="container">
		<!--tab heading-->
		<ul class="nav nav-tabs nabbar_inverse" id="myTab" style="background:#ED2553;border-radius:10px 10px 10px 10px;" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" style="color:#BDDEFD;" id="viewitem-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="viewitem" aria-selected="true">View product Items</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" style="color:#BDDEFD;" id="ManageVendors-tab" data-toggle="tab" href="#ManageVendors" role="tab" aria-controls="ManageVendors" aria-selected="false">Manage Vendors</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" style="color:#BDDEFD;" id="orderstatus-tab" data-toggle="tab" href="#orderstatus" role="tab" aria-controls="orderstatus" aria-selected="false">Order status</a>
			</li>
		</ul>
		<br><br>
		<!--tab 1 starts-->
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="viewitem-tab">
				<div class="container">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Material_Id</th>
								<th scope="col">product View</th>
								<th scope="col">Description</th>
								<th scope="col">Representative Name</th>
								<th scope="col">product Id</th>
								<th scope="col">Remove Vendor</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = mysqli_query($con, "select tblvendor.pldvendor_id,tblvendor.pld_name,tblvendor.pld_email,tbproduct.product_id,tbproduct.product,tbproduct.description,tbproduct.pldimage from  tblvendor right join tbproduct on tblvendor.pldvendor_id=tbproduct.pldvendor_id");
							while ($row = mysqli_fetch_array($query)) {
							?>
								<tr>
									<th scope="row"><?php echo $row['pldvendor_id']; ?></th>
									<td><img src="image/supplier/<?php echo $row['pld_email'] . "/productimages/" . $row['pldimage']; ?>" height="50px" width="100px">
										<br><?php echo $row['product']; ?>
									</td>
									<td><?php echo $row['description']; ?></td>
									<td><?php echo $row['pld_name']; ?></td>
									<td><?php echo $row['product_id']; ?></td>
									<form method="post">
										<td><a href="deleteVendor.php"><button type="submit" value="<?php echo $row['product_id']; ?>" name="delete" class="btn btn-danger">Remove </button></td>
									</form>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<span style="color:green; text-align:centre;"><?php if (isset($success)) {
																	echo $success;
																} ?></span>
			</div>
			<!--tab 1 ends-->
			<div class="tab-pane fade show" id="ManageVendors" role="tabpanel" aria-labelledby="ManageVendors-tab">
				<div class="container">
					<table class="table">
						<thead>
							<tr>
								<th scope="col"></th>
								<th scope="col">Vendor Id</th>
								<th scope="col">Name</th>
								<th scope="col">Address</th>
								<th scope="col">Remove Vendor</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = mysqli_query($con, "select  * from tblvendor");
							while ($row = mysqli_fetch_array($query)) {
							?>
								<tr>
									<td><img src="image/supplier/<?php echo $row['pld_email'] . "/" . $row['pld_logo']; ?>" height="50px" width="100px"></td>
									<th scope="row"><?php echo $row['pldvendor_id']; ?></th>
									<td><?php echo $row['pld_name']; ?></td>
									<td><?php echo $row['pld_address']; ?></td>
									<form method="post">
										<td><a href="#" style="text-decoration:none; color:white;" onclick="delRecord(<?php echo $row['pldvendor_id']; ?>)"><button type="button" class="btn btn-danger">Remove Vendor</a></a></td>
									</form>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<!--tab 3-->
			<div class="tab-pane fade" id="orderstatus" role="tabpanel" aria-labelledby="orderstatus-tab">
				<table class="table">
					<th>Order Id</th>
					<th>product Id</th>
					<th>Customer Email Id</th>
					<th>order Status</th>
					<tbody>
						<?php
						$rr = mysqli_query($con, "select * from tblorder");
						while ($rrr = mysqli_fetch_array($rr)) {
							$stat = $rrr['pldstatus'];
							$productid = $rrr['pld_product_id'];
							$r_f = mysqli_query($con, "select * from tbproduct where product_id='$productid'");
							$r_ff = mysqli_fetch_array($r_f);
						?>
							<tr>
								<td><?php echo $rrr['pld_order_id']; ?></td>
								<td><a href="searchproduct.php?product_id=<?php echo $rrr['pld_product_id']; ?>"><?php echo $rrr['pld_product_id']; ?></td>
								<td><?php echo $rrr['pld_email_id']; ?></td>
								<?php
								if ($stat == "cancelled" || $stat == "Out Of Stock") {
								?>
									<td><i style="color:orange;" class="fas fa-exclamation-triangle"></i>&nbsp;<span style="color:red;"><?php echo $rrr['pldstatus']; ?></span></td>
								<?php
								} else {
								?>
									<td><span style="color:green;"><?php echo $rrr['pldstatus']; ?></span></td>
								<?php
								}
								?>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br><br><br>
	<?php
	include("footer.php");
	?>
</body>
</html>