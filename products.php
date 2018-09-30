<?php 
	include('layouts/header.php');

	include('process.php'); 
	require_once('mysqli_connect.php');

echo '<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
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
if (isset($_GET['edit']))
	{
		$prodCode = $_GET['edit'];
		$edit_state = true;
		$record = @mysqli_query($dbc, "SELECT * FROM PRODUCT_13017 WHERE prodCode=$prodCode");
		$rec = mysqli_fetch_array($record);

		
		$prodCode = $rec['prodCode'];
		$brand = $rec['brand'];
		$type = $rec['type'];
		$shade = $rec['shade'];
		$size = $rec['size'];
		$salesPrice = $rec['salesPrice'];
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

<h1 align = "middle">Product Table</h1>
	

<?php



$query = "SELECT * FROM PRODUCT_13017";

$response = @mysqli_query($dbc, $query);

if ($response) {

	?>
	<table align = "left" cellspacing="5" cellpadding="8">
	<tr><th align = "left"><b>Product Code</b></th>
	<th align="left"><b>Brand</b></th>
	<th align="left"><b>Type</b></th>
	<th align="left"><b>Shade</b></th>
	<th align="left"><b>Size</b></th>
	<th align="left"><b>Sales Price</b></th>

	<?php if (isset($_SESSION['userID'])) echo '
	<th align="left"><b>Action</b></th>';

	echo '</tr>';
	?>

	<?php

	while ($row = mysqli_fetch_array($response)){
		echo '<tr><td align = "left">' .
		$row['prodCode'] . '</td><td align = "left">' .
		$row['brand'] . '</td><td align = "left">' .
		$row['type'] . '</td><td align = "left">' .
		$row['shade'] . '</td><td align = "left">' .
		$row['size'] . '</td><td align = "left">' .
		$row['salesPrice'] . '</td>'; ?>

		<?php if (isset($_SESSION['userID'])) echo '<td align = "left">
		<a href ="products.php?edit='.$row['prodCode'].'"><button class="btn btn-warning">Edit</button></a>'.
		'<a href ="process.php?delProd='.$row['prodCode'].'"><button class = "btn btn-danger">Delete</a></button></td>';

		echo '</tr>'; ?>
		<?php 

	}

	echo '</table>
	<br><br><br><br><br><br><br><br><br><br><hr>';
	
}


else {
	echo "Couldn't issue database query";
	echo mysqli_error($dbc);
}
?>

<?php 

if(isset($_SESSION['userID']))
{

?>
<div class="test">

<form action = "process.php" method="post">
	<input type = "hidden" name="shopID" value="<?php echo $shopID; ?>">
 	

	<h3 align="middle">Add a new Product</h3>

	<p><b>Product Code</b>: 
	<input type="text" name="prodCode" size="5" value="<?php echo $prodCode; ?>" >
	</p>

	<p><b>Brand</b>: 
	<input type="text" name="brand" size="50" value="<?php echo $brand; ?>" />
	</p>

	<p><b>Type</b>: 
	<input type="text" name="type" size="50" value="<?php echo $type; ?>" />
	</p>

	<p><b>Shade</b>: 
	<input type="text" name="shade" size="35" value="<?php echo $shade; ?>" />
	</p>

	<p><b>Size</b>: 
	<input type="text" name="size" size="20" value="<?php echo $size; ?>" />
	</p>

	<p><b>Sales Price</b>: 
	<input type="text" name="salesPrice" size="30" value="<?php echo $salesPrice; ?>" />
	</p>

<?php 

	if (!$edit_state) {
		echo '<p>

		<input type="submit" name="submitProd" value="Send" />
		
	</p>';
	}
	else {
		echo '<p>

		<input type="submit" name="updateProd" value="Update" />
		
	</p>';

	}

	echo '
	

</form>
</div>

';
}

else
{
	echo '<h5>In order to add a product, please log in! Thank you</h5>';
}



include('layouts/footer.php');

mysqli_close($dbc);


?>
