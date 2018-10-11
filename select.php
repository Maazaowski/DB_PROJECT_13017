<?php 
	include('layouts/header.php');

	include('process.php'); 
	require_once('mysqli_connect.php');

    $SPID = 0;
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

<h1 align = "middle">Select Customer</h1>
<hr>
	

<?php



$query = "SELECT * FROM SALESPERSON_13017 WHERE SPID=$SPID";

$response = @mysqli_query($dbc, $query);

if ($response) {

	?>
	<table align = "left" cellspacing="5" cellpadding="8">
	<tr><th align = "left"><b>Salesperson ID</b></th>
	<th align="left"><b>Salesperson</b></th>
	<?php
	echo '</tr>';
	?>

	<?php

	$row = mysqli_fetch_array($response);
		echo '<tr><td align = "left">' .
		$row['SPID'] . '</td><td align = "left">' .
		$row['name'] . '</td>'; ?>
		<?php 
		echo '</tr>'; ?>
		<?php 

	

	echo '</table>
	<br><br><br><br><hr>';
	
}


else {
	echo "Couldn't issue database query";
	echo mysqli_error($dbc);
}
?>

<?php 

if(isset($_SESSION['userID']))
{

    $query2 = "SELECT custID FROM SALESPERSON_13017 WHERE SPID=$SPID";
    $response2 = @mysqli_query($dbc, $query2);
?>


<table align = "left" cellspacing="5" cellpadding="8">
	<tr><th align = "left"><b>Customer ID</b></th>
	<th align="left"><b>Action</b></th>
	</tr>
	
<div class="test">

<?php
while ($row2 = mysqli_fetch_array($response2)){
		echo '<tr><td align = "left">' .
		$row2['custID'] . '</td>';?>
		<?php echo '<td align = "left">
		<a href ="invoice.php?inv='.$row2['custID'].'"><button class="btn btn-warning">Select</button></a>';
		echo '</tr>'; 		

    }
    
echo '</div>
    </table>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br>';

}



include('layouts/footer.php');

mysqli_close($dbc);


?>
