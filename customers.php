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
		$shopID = $_GET['edit'];
		$edit_state = true;
		$record = @mysqli_query($dbc, "SELECT * FROM CUSTOMER_13017 WHERE shopID=$shopID");
		$rec = mysqli_fetch_array($record);

		
		$shopName = $rec['shopName'];
		$address = $rec['address'];
		$contact = $rec['contact'];
		$contactNo = $rec['contactNo'];
		$area = $rec['area'];
		$coordinates = $rec['coordinates'];
		$createdBy = $rec['createdBy'];



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

<h1 align = "middle">Customer Table</h1>
<hr>
	

<?php



$query = "SELECT shopID, shopName, address, contact, contactNo, area, coordinates, createdDate, createdBy FROM CUSTOMER_13017";

$response = @mysqli_query($dbc, $query);

if ($response) {

	?>
	<table align = "left" cellspacing="5" cellpadding="8">
	<tr><th align = "left"><b>Shop ID</b></th>
	<th align="left"><b>Shop Name</b></th>
	<th align="left"><b>Address</b></th>
	<th align="left"><b>Contact</b></th>
	<th align="left"><b>Contact Number</b></th>
	<th align="left"><b>Area</b></th>
	<th align="left"><b>Coordinates</b></th>
	<th align="left"><b>Created At</b></th>
	<th align="left"><b>Created By</b></th>
	<?php if (isset($_SESSION['userID'])) echo '
	<th align="left"><b>Action</b></th>';

	echo '</tr>';
	?>

	<?php

	while ($row = mysqli_fetch_array($response)){
		echo '<tr><td align = "left">' .
		$row['shopID'] . '</td><td align = "left">' .
		$row['shopName'] . '</td><td align = "left">' .
		$row['address'] . '</td><td align = "left">' .
		$row['contact'] . '</td><td align = "left">' .
		$row['contactNo'] . '</td><td align = "left">' .
		$row['area'] . '</td><td align = "left">' .
		$row['coordinates'] . '</td><td align = "left">' .
		$row['createdDate'] . '</td><td align = "left">' .
		$row['createdBy'] . '</td>'; ?>
		<?php if (isset($_SESSION['userID'])) echo '<td align = "left">
		<a href ="customers.php?edit='.$row['shopID'].'"><button class="btn btn-warning">Edit</button></a>'.
		'<a href ="process.php?del='.$row['shopID'].'"><button class = "btn btn-danger">Delete</a></button></td>';

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
 	

	<h3 align="middle">Add a new Student</h3>

	<p><b>Shop ID</b>: 
	<input type="text" name="shopID" size="5" value="<?php echo $shopID; ?>" >
	</p>

	<p><b>Shop Name</b>: 
	<input type="text" name="shopName" size="50" value="<?php echo $shopName; ?>" />
	</p>

	<p><b>Address</b>: 
	<input type="text" name="address" size="50" value="<?php echo $address; ?>" />
	</p>

	<p><b>Contact</b>: 
	<input type="text" name="contact" size="35" value="<?php echo $contact; ?>" />
	</p>

	<p><b>Contact Number</b>: 
	<input type="text" name="contactNo" size="20" value="<?php echo $contactNo; ?>" />
	</p>

	<p><b>Area</b>: 
	<input type="text" name="area" size="30" value="<?php echo $area; ?>" />
	</p>

	<p><b>Coordinates</b>: 
	<input type="text" name="coordinates" size="30" value="<?php echo $coordinates; ?>" />
	</p>

	<p><b>Created By</b>: 
	<input type="text" name="createdBy" size="20" value="<?php echo $createdBy; ?>" />
	</p>

<?php 

	if (!$edit_state) {
		echo '<p>

		<input type="submit" name="submit" value="Send" />
		
	</p>';
	}
	else {
		echo '<p>

		<input type="submit" name="update" value="Update" />
		
	</p>';

	}

	echo '
	

</form>
</div>

';
}

else
{
	echo '<h5>In order to add a customer, please log in! Thank you</h5>';
}



include('layouts/footer.php');

mysqli_close($dbc);


?>
