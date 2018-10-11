<?php 
	include('layouts/header.php');

	include('process.php'); 
	require_once('mysqli_connect.php');

	if (!isset($_SESSION['userID']))
	{
		header('location: login.php');
	}


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
	
		$SPID = $_GET['edit'];
		$edit_state = true;
		$record = @mysqli_query($dbc, "SELECT * FROM SALESPERSON_13017 WHERE SPID=$SPID");
		$rec = mysqli_fetch_array($record);

		
		$name = $rec['name'];
		$contactNo = $rec['contactNo'];
		//$custID = $rec['SPID'];
		



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

$manager = 0;
if(isset($_SESSION['userID']))
{
	$ID = $_SESSION['userID'];
	$query = "SELECT manager FROM USERS_13017 WHERE userID=$ID";
	$response = @mysqli_query($dbc, $query);
	$rec = mysqli_fetch_array($response);
	$manager = $rec['manager'];
}

$admin = 0;
if(isset($_SESSION['userID']))
{
	$ID = $_SESSION['userID'];
	$query = "SELECT admin FROM USERS_13017 WHERE userID=$ID";
	$response = @mysqli_query($dbc, $query);
	$rec = mysqli_fetch_array($response);
	$admin = $rec['admin'];
}



?>

<h1 align = "middle">Salesperson Table</h1>
<hr>
	

<?php



$query = "SELECT * FROM SALESPERSON_13017";
$query2 = "SELECT a.shopID FROM CUSTOMER_13017 a LEFT JOIN SALESPERSON_13017 b ON b.custID = a.shopID WHERE b.custID IS NULL";	

$response = @mysqli_query($dbc, $query);
$response2 = @mysqli_query($dbc, $query2);

if ($response) {

	?>
	<table align = "left" cellspacing="5" cellpadding="8">
	<tr><th align = "left"><b>Salesperson ID</b></th>
	<th align="left"><b>Name</b></th>
	<th align="left"><b>Contact No</b></th>
	<th align="left"><b>Customer Assigned</b></th>
	<?php if ($manager == '1' || $admin == '1') echo '
	<th align="left"><b>Action</b></th>';

	echo '</tr>';
	?>

	<?php

	while ($row = mysqli_fetch_array($response)){
		echo '<tr><td align = "left">' .
		$row['SPID'] . '</td><td align = "left">' .
		$row['name'] . '</td><td align = "left">' .
		$row['contactNo'] . '</td><td align = "left">' .
		$row['custID'] . '</td>';?>
		<?php if ($manager == '1') echo '<td align = "left">
		<a href ="salesperson.php?edit='.$row['SPID'].'"><button class="btn btn-warning">Edit</button></a>'.
		'<a href ="process.php?delSP='.$row['SPID'].'&delC='.$row['custID'].'"><button class = "btn btn-danger">Delete</a></button></td>';
		if ($admin == '1') {
			echo '<td align = "left">

                          <a href = "salesperson.php?assignNew='.$row['SPID'].'&assignC='.$row['custID'].'"><button type = "submit" class="btn btn-warning" name="custID">Assign New Customer</button></a>';
}

		echo '</tr>'; 
		

	}

	echo '</table>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><hr>';
	
}


else {
	echo "Couldn't issue database query";
	echo mysqli_error($dbc);
}


 


//-----ASSIGN SALESPERSON-----

	




if (isset($_GET['assignNew']))
{
 	$SPID = $_GET['assignNew'];
 	$custID = $_GET['assignC'];
 	$record = @mysqli_query($dbc, "SELECT * FROM SALESPERSON_13017 WHERE (SPID=$SPID AND custID=$custID)");
		$rec = mysqli_fetch_array($record);

		
		$name = $rec['name'];
		$contactNo = $rec['contactNo'];
 	?>


 	<div class="test">

<form action = "process.php" method="post">
	<input type = "hidden" name="SPID" value="<?php echo $SPID; ?>">
 	

	<h3 align="middle">Assign a new Customer</h3>

	<p><b>Salesperson ID</b>: 
	<input type="text" name="SPID" size="5" value="<?php echo $SPID; ?>" readonly>
	</p>

	<p><b>Name</b>: 
	<input type="text" name="name" size="50" value="<?php echo $name; ?>" readonly/>
	</p>

	<p><b>Contact No</b>: 
	<input type="text" name="contactNo" size="50" value="<?php echo $contactNo; ?>" readonly/>
	</p>
	
		<div class="form-group">
                            <label for="custID" class="col-md-4 control-label">Customer ID</label>
                            <div class="col-md-6">
                                <select class="form-control" id="custID" name="custID">
                                	<?php while($row2 = mysqli_fetch_array($response2)) {
                                  echo '<option>'.$row2['shopID'].'</option>';
                              } ?>
                                </select>
                            </div>
                          </div>

	<p>

		<input type="submit" name="assignNew" value="Assign" />
		
	</p>
</form>
</div>

<?php 
}

	//-----ASSIGN SALESPERSON ENDS-----


	if ($manager == '1')
	{

?>
<div class="test">

<form action = "process.php" method="post">
	<input type = "hidden" name="SPID" value="<?php echo $SPID; ?>">
 	

	<h3 align="middle">Add a new Salesperson</h3>

	<p><b>Salesperson ID</b>: 
	<input type="text" name="SPID" size="5" value="<?php echo $SPID; ?>" >
	</p>

	<p><b>Name</b>: 
	<input type="text" name="name" size="50" value="<?php echo $name; ?>" />
	</p>

	<p><b>Contact No</b>: 
	<input type="text" name="contactNo" size="50" value="<?php echo $contactNo; ?>" />
	</p>

	<p><b>Customer Assigned</b>: 
	<input type="text" name="custID" size="50" value="<?php echo $custID; ?>" readonly/>
	</p>

<?php 

	if (!$edit_state) {
		echo '<p>

		<input type="submit" name="submitSP" value="Send" />
		
	</p>';
	}
	else {
		echo '<p>

		<input type="submit" name="updateSP" value="Update" />
		
	</p>';

	}

	echo '
	

</form>
</div>

';
	}


	else
	{
		echo '<h5>In order to add a salesperson, please log in as Manager! Thank you</h5>';
	}





include('layouts/footer.php');

mysqli_close($dbc);


?>
