	<?php 
	include('layouts/header.php');

	include('process.php'); 
require_once('mysqli_connect.php');

	


?>
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
	echo '<h1>WELCOME TO MY DATABASE PROJECT!</h1>';
}



?>

<br><br><br><br><br><br><br><br><br><br><br><br><br>

	<?php


include('layouts/footer.php');

mysqli_close($dbc);


?>

