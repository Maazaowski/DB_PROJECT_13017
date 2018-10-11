<?php
	require_once('mysqli_connect.php');
	$edit_state = false;
	session_start();


	//-----USER REGISTRATION-----

	if(isset($_POST['submitUser'])) {

		$data_missing = array();

		if (empty($_POST['userID'])) {
			$data_missing[] = 'User ID';
		}
		else {
			$userID = trim($_POST['userID']);
		}

		if (empty($_POST['password'])) {
			$data_missing[] = 'Password';
		}
		else {
			$password = trim($_POST['password']);
		}


		if (empty($_POST['password_confirmation'])) {
			$data_missing[] = 'Password';
		}
		else {
			$password_c = trim($_POST['password_confirmation']);
		}

		if (empty($_POST['plan'])) {
			$data_missing[] = 'Plan';
		}
		else {
			$plan = trim($_POST['plan']);
		}
		if (empty($_POST['salesID'])) {
			$salesID = '0';
		}
		else {
			$salesID = trim($_POST['salesID']);
		}



		if(empty($data_missing)) {

			if(!($password == $password_c))
			{
				$_SESSION['error_msg'] = "Passwords do not match";
				header('location: login.php');
			}
			
			else {

				$password1 = md5($password);

				if ($plan == "Salesperson")
				{
					$query = "INSERT INTO USERS_13017 VALUES ('$userID', '$password1', '1', '1', '0', '0', '$salesID')";
				}
				elseif ($plan == "Sales Manager")
				{
					$query = "INSERT INTO USERS_13017 VALUES ('$userID', '$password1', '1', '0', '0', '1', NULL)";
				}
				elseif ($plan == "Admin")
				{
					$query = "INSERT INTO USERS_13017 VALUES ('$userID', '$password1', '1', '0', '1', '0', NULL)";
				}
				else {
					$query = "INSERT INTO USERS_13017 VALUES ('$userID', '$password1', '1', '0', '0', '0', NULL)";
				}

			$response = mysqli_query($dbc, $query);

			if($response)
			{

				$_SESSION['success_msg'] = "User created successfully!";
				 header('location: index.php');
			}
			else
			{
				$_SESSION['error_msg'] = "An error occured";
				header('location: index.php');
			}
		}
	}
		else {
			echo 'You need to enter the following data <br />';
			foreach($data_missing as $mis)
			{
				echo "$mis<br />";
			}		

		}
	}

	//-----USER REGISTRATION ENDS-----




	//-----USER UPDATE-----

	if(isset($_POST['updateUser'])) {

		$data_missing = array();

		if (empty($_POST['userID'])) {
			$data_missing[] = 'User ID';
		}
		else {
			$userID = trim($_POST['userID']);
		}

		if (empty($_POST['password'])) {
			$data_missing[] = 'Password';
		}
		else {
			$password = trim($_POST['password']);
		}


		if (empty($_POST['password_confirmation'])) {
			$data_missing[] = 'Password';
		}
		else {
			$password_c = trim($_POST['password_confirmation']);
		}

		if (empty($_POST['plan'])) {
			$data_missing[] = 'Plan';
		}
		else {
			$plan = trim($_POST['plan']);
		}
		if (empty($_POST['salesID'])) {
			$salesID = '0';
		}
		else {
			$salesID = trim($_POST['salesID']);
		}



		if(empty($data_missing)) {

			if(!($password == $password_c))
			{
				$_SESSION['error_msg'] = "Passwords do not match";
				header('location: users.php');
			}
			
			else {

				$password1 = md5($password);

				if ($plan == "Salesperson")
				{
					$query = "UPDATE USERS_13017 SET password='$password1', active='1', salesPerson='1', admin='0', manager='0', salesID='$salesID' WHERE userID=$userID";
				}
				elseif ($plan == "Sales Manager")
				{
					$query = "UPDATE USERS_13017 SET password='$password1', active='1', salesPerson='0', admin='0', manager='1', salesID=NULL WHERE userID=$userID";
				}
				elseif ($plan == "Admin")
				{
					$query = "UPDATE USERS_13017 SET password='$password1', active='1', salesPerson='0', admin='1', manager='0', salesID=NULL WHERE userID=$userID";
				}
				else {
					$query = "UPDATE USERS_13017 SET password='$password1', active='1', salesPerson='0', admin='0', manager='0', salesID=NULL WHERE userID=$userID";
				}

			$response = mysqli_query($dbc, $query);

			if ($response)
			{
				
				$_SESSION['success_msg'] = "User updated successfully!";
				 header('location: users.php');
			}
			else
			{
				$_SESSION['error_msg'] = "An error occured";
				header('location: users.php');
			}

		}
	}
		else {
			echo 'You need to enter the following data <br />';
			foreach($data_missing as $mis)
			{
				echo "$mis<br />";
			}		

		}
	}
	//-----USER UPDATE ENDS-----





	//-----USER LOGSOUT-----


	if (isset($_GET['logout']))
	{
		session_destroy();
		unset($_SESSION['userID']);
		header('location: index.php');
	}

	//-----USER LOGSOUT ENDS-----




	//-----USER LOGSIN-----


	if (isset($_POST['login']))
	{
		$data_missing = array();

		if (empty($_POST['userID'])) {
			$data_missing[] = 'User ID';
		}
		else {
			$userID = trim($_POST['userID']);
		}

		if (empty($_POST['password'])) {
			$data_missing[] = 'Password';
		}
		else {
			$password = trim($_POST['password']);
		}

		if(empty($data_missing)) {

			$pass = md5($password);

			$query = "SELECT * FROM USERS_13017 WHERE userID=$userID";
			$response = @mysqli_query($dbc, $query);

			if ($response) {
				$row = mysqli_fetch_array($response);

				if($row['userID'] = $userID && $row['password'] == $pass)
				{
					$_SESSION['userID'] = $userID;
					if($row['salesPerson'] != 1)
					 header('location: index.php');
					else
					 header('location: invoice.php');
				}
				else
				{
					$_SESSION['error_msg'] = "UserID or password does not match our records!";
					header('location: login.php');
				}

				

			}

			else {
				$_SESSION['error_msg'] = "UserID or password does not Match our records!";
				header('location: login.php');
				
			}


		}

		else
		{
			echo 'You need to enter the following data <br />';
			foreach($data_missing as $mis)
			{
				echo "$mis<br />";
			}	
		}
	}

	//-----USER LOGSIN ENDS-----




	//-----USER DELETION-----

	if (isset($_GET['delUser']))
	{
		$userID = $_GET['delUser'];
		$response = mysqli_query($dbc, "DELETE FROM USERS_13017 WHERE userID=$userID");
		if ($response)
		{
		$_SESSION['success_msg'] = "User Removed";
				 
		}
		else
		{
			$_SESSION['error_msg'] = "An error occurred";
		}
		header('location: users.php');
	}

	//-----USER DELETION ENDS





	//-----SUBMIT CUSTOMER INFO-----


	if(isset($_POST['submit'])) {

		$data_missing = array();

		if (empty($_POST['shopID'])) {
			$data_missing[] = 'Shop ID';
		}
		else {
			$shopID = trim($_POST['shopID']);
		}

		if (empty($_POST['shopName'])) {
			$data_missing[] = 'Shop Name';
		}
		else {
			$shopName = trim($_POST['shopName']);
		}


		if (empty($_POST['address'])) {
			$data_missing[] = 'Address';
		}
		else {
			$address = trim($_POST['address']);
		}

		if (empty($_POST['contact'])) {
			$data_missing[] = 'Contact';
		}
		else {
			$contact = trim($_POST['contact']);
		}

		if (empty($_POST['contactNo'])) {
			$data_missing[] = 'Contact Number';
		}
		else {
			$contactNo = trim($_POST['contactNo']);
		}

		if (empty($_POST['area'])) {
			$data_missing[] = 'Area';
		}
		else {
			$area = trim($_POST['area']);
		}

		if (empty($_POST['coordinates'])) {
			$data_missing[] = 'Coordinates';
		}
		else {
			$coordinates = trim($_POST['coordinates']);
		}

		if (empty($_POST['createdBy'])) {
			$data_missing[] = 'Created By';
		}
		else {
			$createdBy = trim($_POST['createdBy']);
		}

		if(empty($data_missing)) {
			

			$query = "INSERT INTO CUSTOMER_13017 (shopID, shopName, address, contact, contactNo, area, coordinates, createdDate, createdBy) VALUES ('$shopID', '$shopName', '$address', '$contact', '$contactNo', '$area', '$coordinates',NOW(), '$createdBy')";

			mysqli_query($dbc, $query);

				$_SESSION['success_msg'] = "Customer Entered";
				 header('location: customers.php');
		}
		else {
			echo 'You need to enter the following data <br />';
			foreach($data_missing as $mis)
			{
				echo "$mis<br />";
			}		

		}
	
	}


	//-----SUBMIT CUSTOMER INFO ENDS-----




	//-----UPDATE CUSTOMER INFO-----

	if (isset($_POST['update'])){
		$shopID = $_POST['shopID'];
		$shopName = $_POST['shopName'];
		$address = $_POST['address'];
		$contact = $_POST['contact'];
		$contactNo = $_POST['contactNo'];
		$area = $_POST['area'];
		$coordinates = $_POST['coordinates'];
		$createdBy = $_POST['createdBy'];

		mysqli_query($dbc, "UPDATE CUSTOMER_13017 SET shopName='$shopName', address='$address', contact='$contact', contactNo='$contactNo', area='$area', coordinates='$coordinates', createdBy='$createdBy' WHERE shopID=$shopID");
		$_SESSION['success_msg'] = "Customer Updated";
				 header('location: customers.php');

	}

	//-----UPDATE CUSTOMER INFO ENDS-----




	//-----DELETE CUSTOMER INFO-----

	if (isset($_GET['del']))
	{
		$shopID = $_GET['del'];
		$response = mysqli_query ($dbc, "DELETE FROM CUSTOMER_13017 WHERE shopID=$shopID");
		$res = mysqli_query ($dbc, "SELECT * FROM SALESPERSON_13017 WHERE custID=$shopID");
		if ($res) {
			$row = mysqli_fetch_array($res);
			$SPID = $row['SPID'];
			$res2 = mysqli_query ($dbc, "SELECT * FROM SALESPERSON_13017 WHERE SPID=$SPID");
				if (mysqli_num_rows($res2) == 1)
					mysqli_query ($dbc, "UPDATE SALESPERSON_13017 SET custID='0' WHERE custID=$shopID");
				else
					mysqli_query ($dbc, "DELETE FROM SALESPERSON_13017 WHERE (SPID=$SPID AND custID=$shopID)");

		}
		if($response)
		$_SESSION['success_msg'] = "Customer Removed";
		else
			$_SESSION['error_msg'] = "An error occurred";
				 header('location: customers.php');
	}

	//-----DELETE CUSTOMER INFO ENDS-----




	//-----SUBMIT PRODUCT INFO-----


	if(isset($_POST['submitProd'])) {

		$data_missing = array();

		if (empty($_POST['prodCode'])) {
			$data_missing[] = 'Product Code';
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


		if (empty($_POST['type'])) {
			$data_missing[] = 'Type';
		}
		else {
			$type = trim($_POST['type']);
		}

		if (empty($_POST['shade'])) {
			$data_missing[] = 'Shade';
		}
		else {
			$shade = trim($_POST['shade']);
		}

		if (empty($_POST['size'])) {
			$data_missing[] = 'Size';
		}
		else {
			$size = trim($_POST['size']);
		}

		if (empty($_POST['salesPrice'])) {
			$data_missing[] = 'Sales Price';
		}
		else {
			$salesPrice = trim($_POST['salesPrice']);
		}

		if(empty($data_missing)) {
			

			$query = "INSERT INTO PRODUCT_13017 VALUES ('$prodCode', '$brand', '$type', '$shade', '$size', '$salesPrice')";

			mysqli_query($dbc, $query);

				$_SESSION['success_msg'] = "Product Added";
				 header('location: products.php');
		}
		else {
			echo 'You need to enter the following data <br />';
			foreach($data_missing as $mis)
			{
				echo "$mis<br />";
			}		

		}
	
	}


	//-----SUBMIT PRODUCT INFO ENDS-----




	//-----UPDATE PRODUCT INFO-----

	if (isset($_POST['updateProd'])){
		$prodCode = $_POST['prodCode'];
		$brand = $_POST['brand'];
		$type = $_POST['type'];
		$shade = $_POST['shade'];
		$size = $_POST['size'];
		$salesPrice = $_POST['salesPrice'];

		mysqli_query($dbc, "UPDATE PRODUCT_13017 SET prodCode='$prodCode', brand='$brand', type='$type', shade='$shade', size='$size', salesPrice='$salesPrice' WHERE prodCode=$prodCode");
		$_SESSION['success_msg'] = "Product Updated";
				 header('location: products.php');

	}

	//-----UPDATE PRODUCT INFO ENDS-----




	//-----DELETE PRODUCT INFO-----

	if (isset($_GET['delProd']))
	{
		$prodCode = $_GET['delProd'];
		mysqli_query ($dbc, "DELETE FROM PRODUCT_13017 WHERE prodCode=$prodCode");
		$_SESSION['success_msg'] = "Product Removed";
				 header('location: products.php');
	}

	//-----DELETE PRODUCT ENDS-----




	//-----SUBMIT SALESPERSON INFO-----


	if(isset($_POST['submitSP'])) {

		$data_missing = array();

		if (empty($_POST['SPID'])) {
			$data_missing[] = 'Salesperson ID';
		}
		else {
			$SPID = trim($_POST['SPID']);
		}

		if (empty($_POST['name'])) {
			$data_missing[] = 'Name';
		}
		else {
			$name = trim($_POST['name']);
		}


		if (empty($_POST['contactNo'])) {
			$data_missing[] = 'Contact No';
		}
		else {
			$contactNo = trim($_POST['contactNo']);
		}


		if(empty($data_missing)) {


			

			$query = "INSERT INTO SALESPERSON_13017 VALUES ('$name', '$contactNo', '$SPID', '0')";

			mysqli_query($dbc, $query);

				$_SESSION['success_msg'] = "Salesperson Added";
				 header('location: salesperson.php');
		}
		else {
			echo 'You need to enter the following data <br />';
			foreach($data_missing as $mis)
			{
				echo "$mis<br />";
			}		

		}
	
	}


	//-----SUBMIT SALESPERSON INFO ENDS-----




	//-----UPDATE SALESPERSON INFO-----

	if (isset($_POST['updateSP'])){
		$SPID = $_POST['SPID'];
		$name = $_POST['name'];
		$contactNo = $_POST['contactNo'];
		//$custID = $_POST['custID'];


		$response = mysqli_query($dbc, "UPDATE SALESPERSON_13017 SET name='$name', contactNo='$contactNo', SPID='$SPID' WHERE SPID=$SPID");
		
		if ($response){

		$_SESSION['success_msg'] = "Salesperson Updated!";
	}
		else
		{
			$_SESSION['error_msg'] = "An error has occured";
		}
				 header('location: salesperson.php');

	}

	//-----UPDATE SALESPERSON INFO ENDS-----




	//-----DELETE SALESPERSON INFO-----

	if (isset($_GET['delSP']))
	{
		$SPID = $_GET['delSP'];
		$custID = $_GET['delC'];
		$response = mysqli_query($dbc, "DELETE FROM SALESPERSON_13017 WHERE (SPID=$SPID AND custID=$custID)");
		$rec = mysqli_query($dbc, "SELECT * FROM SALESPERSON_13017 WHERE SPID=$SPID");
		$row = mysqli_fetch_array($rec);
		if (!$row)
		mysqli_query ($dbc, "UPDATE USERS_13017 SET salesPerson = '0', salesID = NULL WHERE salesID=$SPID");
		if($response)
		$_SESSION['success_msg'] = "Salesperson Removed";
	else
		$_SESSION['error_msg'] = "An error has occured!";
				 header('location: salesperson.php');
	}

	//-----DELETE SALESPERSON ENDS-----


	//-----ASSIGN CUSTOMER TO SALESPERSON-----

	if (isset($_POST['assignNew']))
	{
		$SPID = $_POST['SPID'];
		$custID = $_POST['custID'];
		$name = $_POST['name'];
		$contactNo = $_POST['contactNo'];
		$response = mysqli_query($dbc, "INSERT INTO SALESPERSON_13017 VALUES ('$name', '$contactNo', '$SPID', '$custID')");


		if ($response){
		$_SESSION['success_msg'] = "Customer Assigned!";
	    mysqli_query ($dbc, "DELETE FROM SALESPERSON_13017 WHERE (SPID=$SPID AND custID=0)");
}
	else
		$_SESSION['error_msg'] = "An error occured";
				 header('location: salesperson.php');
	}



	//-----ASSIGN CUSTOMER TO SALESPERSON ENDS-----



	//-----DELETING FOR INVOICE STARTS-----
	if (isset($_GET['delInv']))
	{
		$orderID = $_GET['delInv'];
		$response = mysqli_query($dbc, "DELETE FROM ORDER_13017 WHERE orderID=$orderID");
		if($response)
		$_SESSION['success_msg'] = "Order Removed";
	else
		$_SESSION['error_msg'] = "An error has occured!";
				 header('location: invoice.php');
	}

	//-----DELETING FOR INVOICE ENDS-----





	 
	
?>
	