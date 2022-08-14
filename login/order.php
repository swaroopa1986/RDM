<?php
include("../connection.php");
echo $cust_id=$_GET['cust_id'];
$query=mysqli_query($con,"select tbproduct.product_id,tbproduct.product,tbproduct.pldvendor_id,tbproduct.cost,tbproduct.description,tbproduct.pldimage,tblcart.pld_cart_id,tblcart.pld_product_id,tblcart.pld_customer_id from tbproduct inner  join tblcart on tbproduct.product_id=tblcart.pld_product_id where tblcart.pld_customer_id='$cust_id'");
$re=mysqli_num_rows($query);
while($row=mysqli_fetch_array($query))
{
	echo "<br>";
	echo "cart id is".$cart_id=$row['pld_cart_id'];
	echo "vendor id is".$ven_id=$row['pldvendor_id'];
	echo "product_id is".$product_id=$row['product_id'];
	echo "cost is".$cost=$row['cost'];
	echo 'payment status is'.$paid="In Process";
	if(mysqli_query($con,"insert into tblorder
	(pld_cart_id,pldvendor_id,pld_product_id,pld_email_id,pld_payment,pldstatus) values
	('$cart_id','$ven_id','$product_id','$cust_id','$cost','$paid')"))
	{
		if(mysqli_query($con,"delete from tblcart where pld_cart_id='$cart_id'"))
		{
			header("location:cart.php");
		}
	}
	else
	{
		echo "failed";
	}
}
?>