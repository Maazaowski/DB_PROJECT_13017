	<?php 
	include('layouts/header.php');

	include('process.php'); 
require_once('mysqli_connect.php');

$record = @mysqli_query($dbc, "SELECT count(*) FROM CUSTOMER_13017");
$rec = mysqli_fetch_array($record);

$cust = $rec[0];

$record = @mysqli_query($dbc, "SELECT count(*) FROM USERS_13017");
$rec = mysqli_fetch_array($record);

$users = $rec[0];

$record = @mysqli_query($dbc, "SELECT count(*) FROM SALESPERSON_13017");
$rec = mysqli_fetch_array($record);

$sales = $rec[0];

$record = @mysqli_query($dbc, "SELECT count(*) FROM PRODUCT_13017");
$rec = mysqli_fetch_array($record);

$prod = $rec[0];


$daata = "{ 'Name': 'Customers', 'Customers' :'".$cust."'}, { 'Name': 'Products', 'Products':'".$prod."'}, { 'Name': 'Users', 'Users':'".$users."'}, {'Name': 'Salesperson', 'Salesperson':'".$sales."'}, ";
$dataa = substr($daata, 0, -2);
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


<br><br>

	<?php

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




<?php 


if (isset($_SESSION['userID']))
{
	echo '<h1>WELCOME BACK, USER# '.$_SESSION['userID'];
	echo '</h1>';

}
else
{
	header('location: login.php');
}



?>
<div id="chart"></div>
 
 <script>
Morris.Bar({
 element : 'chart',
 data:[<?php echo $dataa; ?>],
 xkey:'Name',
 ykeys:['Customers', 'Products', 'Users', 'Salesperson'],
 labels:['Customers', 'Products', 'Users', 'Salesperson'],
 hideHover:'auto',
 stacked:true
});
</script>


</body>
</html>
<br><br><br><br><br><br><br><br><br><br><br><br><br>

	<?php


include('layouts/footer.php');

mysqli_close($dbc);


?>

