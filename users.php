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
		$userID = $_GET['edit'];
		$edit_state = true;
		$record = @mysqli_query($dbc, "SELECT userID, active, salesPerson, admin, manager FROM USERS_13017 WHERE userID=$userID");
		$rec = mysqli_fetch_array($record);

		
		$active = $rec['active'];
		$salesPerson = $rec['salesPerson'];
		$admin = $rec['admin'];
		$manager = $rec['manager'];
		



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

$adm = 0;
if(isset($_SESSION['userID']))
{
	$ID = $_SESSION['userID'];
	$query = "SELECT admin FROM USERS_13017 WHERE userID=$ID";
	$response = @mysqli_query($dbc, $query);
	$rec = mysqli_fetch_array($response);
	$adm = $rec['admin'];
}

?>

<h1 align = "middle">Users Table</h1>
<hr>
	

<?php



$query = "SELECT userID, active, salesPerson, admin, manager, salesID FROM USERS_13017";
$query2 = "SELECT a.SPID FROM SALESPERSON_13017 a LEFT JOIN USERS_13017 b ON b.salesID = a.SPID WHERE b.salesID IS NULL";

$response = @mysqli_query($dbc, $query);
$response2 = @mysqli_query($dbc, $query2);

if ($response) {

	?>
	<table align = "left" cellspacing="5" cellpadding="8">
	<tr><th align = "left"><b>User ID</b></th>
	<th align="left"><b>Active?</b></th>
	<th align="left"><b>Salesperson?</b></th>
	<th align="left"><b>Admin?</b></th>
	<th align="left"><b>Manager?</b></th>
	<th align="left"><b>Salesperson ID</b></th>
	<?php if ($adm == '1') echo '
	<th align="left"><b>Action</b></th>';

	echo '</tr>';
	?>

	<?php

	while ($row = mysqli_fetch_array($response)){
		echo '<tr><td align = "left">' .
		$row['userID'] . '</td><td align = "left">'; 
		if($row['active'] == '1') echo 'Yes'; else echo 'No'; echo '</td><td align = "left">';
		if($row['salesPerson'] == '1') echo 'Yes'; else echo 'No'; echo '</td><td align = "left">';
		if($row['admin'] =='1') echo 'Yes'; else echo 'No'; echo '</td><td align = "left">';
		if($row['manager'] =='1') echo 'Yes'; else echo 'No'; echo '</td><td align = "left">';
		echo $row['salesID'] . '</td>';
		?> <?php if ($adm == '1') echo '<td align = "left">
		<a href ="users.php?edit='.$row['userID'].'"><button class="btn btn-warning">Edit</button></a>'.
		'<a href ="process.php?delUser='.$row['userID'].'"><button class = "btn btn-danger">Delete</a></button></td>';

		echo '</tr>'; ?>
		<?php 

	}

	echo '</table>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><hr>';
	
}


else {
	echo "Couldn't issue database query";
	echo mysqli_error($dbc);
}
?>

<?php 

 

	if ($adm == '1')
	{
?>
		<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Create a User</b></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="process.php">
                        

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">User ID</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="userID" value="<?php echo $userID; ?>" required autofocus>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="" required>

                               
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>            

                        <div class="form-group">
                            <label for="plan" class="col-md-4 control-label">Registering for: </label>
                            <div class="col-md-6">
                                <select class="form-control" id="plan" name="plan" onChange="changeTextBox();" >
                                  <option>None</option>
                                  <option>Salesperson</option>
                                  <option>Sales Manager</option>
                                  <option>Admin</option>
                                  
                                </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="salesID" class="col-md-4 control-label">Sales ID</label>

                            <div class="col-md-6">
                                 <select class="form-control" id="salesID" name="salesID" disabled>
                                 <?php while ($row2 = mysqli_fetch_array($response2)) { 
                                  echo '<option>'.$row2['SPID'].'</option>';
                              } ?>
                                </select>

                            </div>
                        </div>

                        <script type="text/javascript">
							function changeTextBox(){
								
  								if (document.getElementById("plan").value === "Salesperson") {
   								     document.getElementById("salesID").disabled='';
   								} 
   								else {
							
   						 	    document.getElementById("salesID").disabled='true';
   								}
							}
						</script>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                            	<?php
                            		if(!$edit_state)
                            		{  ?>
                            			<button type="submit" name="submitUser" class="btn btn-primary">
                                    						Register
                                		</button>
                            		<?php }

                            		else
                            		{   ?>
                            			<button type="submit" name="updateUser" class="btn btn-primary">
                                   							 Update
                                		</button>
                            	<?php	}  ?>

                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
	}
	else
	{
		echo '<h5>In order to add a user, please log in as Administrator! Thank you</h5>';
	}





include('layouts/footer.php');

mysqli_close($dbc);


?>
