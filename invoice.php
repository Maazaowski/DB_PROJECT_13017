<?php 
	include('layouts/header.php');

	include('process.php'); 
	require_once('mysqli_connect.php');

	$SPID = 0;
	$shopName = '';
	$address = '';
	$contactNo = '';
	if (!isset($_SESSION['userID']))
	{
		header('location: login.php');
    }
    else{
        $ID = $_SESSION['userID'];
        $query = "SELECT salesPerson, salesID FROM USERS_13017 WHERE userID=$ID";
        $response = @mysqli_query($dbc, $query);
        $rec = mysqli_fetch_array($response);
        
        if ($rec['salesPerson'] != 1)
        {
            header('location: index.php');
        }
        else{
            $SPID = $rec['salesID'];
        }
	}
	
	// SUBMIT INVOICE STARTS

if(isset($_POST['submitOrder'])) {

	$data_missing = array();

	if (empty($_POST['custID'])) {
		$data_missing[] = 'Customer ID';
	}
	else {
		$custID = trim($_POST['custID']);
	}

	if (empty($_POST['orderID'])) {
		$data_missing[] = 'Order ID';
	}
	else {
		$orderID = trim($_POST['orderID']);
	}


	if (empty($_POST['prodCode'])) {
		$data_missing[] = 'Product ID';
	}
	else {
		$prodCode = trim($_POST['prodCode']);
	}

	if (empty($_POST['brand'])) {
		$data_missing[] = 'Brand';
	}
	else {
		$brand = trim($_POST['brand']);
	}

	if (empty($_POST['quantity'])) {
		$data_missing[] = 'Quantity Number';
	}
	else {
		$quantity = trim($_POST['quantity']);
	}

	if (empty($_POST['rate'])) {
		$data_missing[] = 'Rate';
	}
	else {
		$rate = trim($_POST['rate']);
	}

	if (empty($_POST['total'])) {
		$data_missing[] = 'Total';
	}
	else {
		$total = trim($_POST['total']);
	}

	if(empty($data_missing)) {
		

		$queryI = "INSERT INTO ORDER_13017 VALUES ('$orderID', '$prodCode', '$brand', '$custID', '$quantity', '$rate', '$total')";

		$responseI = mysqli_query($dbc, $queryI);

			if ($responseI)
			$_SESSION['success_msg'] = "Order Entered";
			else
			$_SESSION['error_msg'] = "Error: ".mysqli_error($dbc);
			header('location: invoice.php');
	}
	else {
		echo 'You need to enter the following data <br />';
		foreach($data_missing as $mis)
		{
			echo "$mis<br />";
		}		

	}

}

// SUBMIT INVOICE ENDS







//EDIT INVOICE STARTS
if (isset($_POST['updateOrder'])){
	$custID = $_POST['custID'];
	$orderID = $_POST['orderID'];
	$prodCode = $_POST['prodCode'];
	$brand = $_POST['brand'];
	$total = $_POST['total'];
	$quantity = $_POST['quantity'];
	$rate = $_POST['rate'];

	$response = mysqli_query($dbc, "UPDATE ORDER_13017 SET custID='$custID', orderID='$orderID', prodID='$prodCode', product='$brand', rate='$rate', quantity='$quantity', total='$total' WHERE orderID=$orderID");
	if ($response)
	$_SESSION['success_msg'] = "Order Updated";
	else
	$_SESSION['error_msg'] = "An error occurred";
			 header('location: invoice.php');

}

//EDIT INVOICE ENDS

echo '<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: middle;
    padding: 8px;

}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
tr:hover {background-color: #f5f5f5;}


input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

test {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>

<br><br>';

if(isset($_POST['quantity']))
{
	$quantity = $_POST['quantity'];
	header('location: index.php');

}

if(isset($_POST['custID']))
{
	$custID = $_POST['custID'];
	header('location: invoice.php?inv='.$custID);
}

if(isset($_POST['prodCode']))
{
	$prodCode = $_POST['prodCode'];
	header('location: invoice.php?inv='.$custID.'&prodCode='.$prodCode);
}

if (isset($_GET['inv']))
{
	$custID = $_GET['inv'];
	$query2 = "SELECT * FROM CUSTOMER_13017 WHERE shopID=$custID";
	$query3 = "SELECT * FROM ORDER_13017 WHERE custID=$custID";
	$queryP = "SELECT * FROM PRODUCT_13017";

	$response22 = @mysqli_query($dbc, $query2);
	$response3 = @mysqli_query($dbc, $query3);
	$responseP = @mysqli_query($dbc, $queryP);

	$row22 = mysqli_fetch_array($response22);
	$shopName = $row22['shopName'];
	$address = $row22['address'];
	$contactNo = $row22['contactNo'];

}

if (isset($_GET['prodCode']))
{
	$prodCode = $_GET['prodCode'];
	$query4 = "SELECT * FROM PRODUCT_13017 WHERE prodCode = $prodCode";
	$response4 = @mysqli_query($dbc, $query4);
	$row4 = mysqli_fetch_array($response4);

	$brand = $row4['brand'];
	$rate = $row4['salesPrice'];
}

if (isset($_GET['quantity']))
{
	$quantity = $_GET['quantity'];
	$total = $rate * $quantity;
}


if (isset($_GET['edit']))
	{
		$orderID = $_GET['edit'];
		$edit_state = true;
		$record = @mysqli_query($dbc, "SELECT * FROM ORDER_13017 WHERE orderID=$orderID");
		$rec = mysqli_fetch_array($record);

		$brand = $rec['product'];
        $prodCode = $rec['prodID'];
        $custID = $rec['custID'];
		$quantity = $rec['quantity'];
		$total = $rec['total'];
		$rate = $rec['rate'];



	}

	if (isset($_SESSION['success_msg']))
    {
        echo '<br><br><div class="bg bg-success">';
        echo '<b>'; echo $_SESSION['success_msg']; echo '</b>';
        unset($_SESSION['success_msg']);

        echo '
        </div>';
    }

if (isset($_SESSION['error_msg']))
{
        echo '<br><br><div class="bg bg-danger">';
        echo '<b>'; echo $_SESSION['error_msg']; echo '</b>';
        unset($_SESSION['error_msg']);

        echo '
        </div>';
}

?>

<script type = "text/javascript">

function setTotal($quantity) {

	var quantity = document.getElementById("quantity").value;
	var rate = document.getElementById("rate").value;


	document.getElementById("total").value = quantity*rate;

}

</script>

<h1 align = "middle">Invoice</h1>
<hr>
	

<?php



$query = "SELECT * FROM SALESPERSON_13017 WHERE SPID=$SPID";



$response = @mysqli_query($dbc, $query);
$response2 = @mysqli_query($dbc, $query);


if ($response) {

	?>
	<table align = "middle" cellspacing="5" cellpadding="8">
	<tr><th align = "middle"><b>Salesperson ID</b></th>
	<th align="middle"><b>Salesperson</b></th>
	<th align="middle"><b>Customer ID</b></th>
	<th align="middle"><b>Customer</b></th>
	<th align="middle"><b>Customer Address</b></th>
	<th align="middle"><b>Customer Contact Number</b></th>
	<?php 
	echo '</tr>';
	?>

	<?php
	
	$row = mysqli_fetch_array($response);
	//$row2 = mysqli_fetch_array($response2);
		echo '<form method="post" enctype="multipart/form-data">';
		echo '<tr><td align = "middle">' .
		$row['SPID'] . '</td><td align = "middle">' .
		$row['name'] . '</td><td align = "middle">'; ?>
		<select value = <?php echo $custID ?> class="form-control" id="custID" name="custID" onChange="this.form.submit();">
			<option>Select Customer: </option>
            <?php while($row2 = mysqli_fetch_array($response2)) {
                ?> <option <?php if ($custID == $row2['custID']) echo "selected"; echo '>'.$row2['custID'].'</option>';
                    } ?>
        </select> <?php echo '</td><td align = "middle">' .
		$shopName . '</td><td align = "middle">' .
		$address . '</td><td align = "middle">' .
		$contactNo . '</td>'; ?>
		<?php 
		echo '</tr></form>'; ?>
		<?php 

	

	echo '</table>
	<hr><br><br><br>	';
	
}


else {
	echo "Couldn't issue database query";
	echo mysqli_error($dbc);
}

if (isset($_GET['inv'])) {
?>

<h1 align = "middle">Order</h1>

<table align = "middle" cellspacing="5" cellpadding="8">
	<tr><th align="middle"><b>Customer ID</b></th>
	<th align = "middle"><b>Order ID</b></th>
	<th align="middle"><b>Brand</b></th>
	<th align="middle"><b>Product ID</b></th>
	<th align="middle"><b>Quantity</b></th>
	<th align="middle"><b>Rate</b></th>
	<th align="middle"><b>Total</b></th>
	<th align="middle"><b>Action</b></th>
	</tr>
	<?php
		while ($row3 = mysqli_fetch_array($response3)){
			echo '<tr><td align = "middle">' .
			$row3['custID'] . '</td><td align = "middle">' .
			$row3['orderID'] . '</td><td align = "middle">' .
			$row3['product'] . '</td><td align = "middle">' .
			$row3['prodID'] . '</td><td align = "middle">' .
			$row3['quantity'] . '</td><td align = "middle">' .
			$row3['rate'] . '</td><td align = "middle">' .
			$row3['total'] . '</td>';?>
			<?php  echo '<td align = "middle">
			<a href ="invoice.php?inv='.$custID.'&edit='.$row3['orderID'].'"><button class="btn btn-warning">Edit</button></a>'.
			'<a href ="process.php?delInv='.$row3['orderID'].'"><button class = "btn btn-danger">Delete</a></button></td></tr>';	
			
		}

		?>

		<hr>
		

		<br>
		
		<div class="test">
		<form action = "invoice.php" method="post">
			<td align = "middle"> <input type="text" name="custID" size="5" value="<?php echo $custID; ?>" readonly></td>
			<td align = "middle"> <input type="text" name="orderID" size="5" value="<?php echo $orderID; ?>"></td>
			<td align = "middle"> <select class="form-control" name="prodCode" onChange="this.form.submit();">
			<option>Select Product: </option>
            <?php while($rowP = mysqli_fetch_array($responseP)) {
                ?> <option <?php if ($prodCode == $rowP['prodCode']) echo "selected"; echo '>'.$rowP['prodCode'].'</option>';
                    } ?>
        </select></td>
			<td align = "middle"> <input type="text" id="brand" name="brand" size="5" value="<?php echo $brand; ?>" readonly></td>
			<td align = "middle"> <input type="text" id = "quantity" name="quantity" size="5" value="<?php echo $quantity; ?>" onChange="setTotal();"></td>
			<td align = "middle"> <input type="text" id = "rate" name="rate" size="5" value="<?php echo $rate; ?>" readonly></td>
			<td align = "middle"> <input type="text" id = "total" name="total" size="5" value="<?php echo $total; ?>" readonly></td>
		</tr>
	
		


		
		</table>

		<?php

			if (!$edit_state) {
				echo '<input type="submit" name="submitOrder" value="Add" />';
			}
			else {
				echo '<input type="submit" name="updateOrder" value="Update" />';
			}

		?>
		
		</form>
		</div>
		<br>
		<?php 
	}

	





include('layouts/footer.php');

mysqli_close($dbc);



?>
