<?php
include('process.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Database Project</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Candal|Alegreya+Sans">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/imagehover.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" type="text/css" href="styles.css">

	
</head>
<body id="page-top">

  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
       
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
      	 <ul class="nav navbar-nav navbar-left"><li><a href="index.php">Home</a></li></ul>
        <ul class="nav navbar-nav navbar-right">
          
          <li><a href="customers.php">Customers</a></li>
        <li><a href="salesperson.php">Salesperson</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="users.php">Users</a></li>
         

          <?php

          if(isset($_SESSION['userID']))
          {
          	?>
          	 <li>
                  <a >
                        <?php echo $_SESSION['userID'] ?> 
                  </a>
              </li>

                  
                      <li>
                        <a href="process.php?logout='1'">
                            Logout
                        </a>
                      </li>
          	<?php
          }
          else
          {
          	echo '<li class="btn-trial"><a href="login.php">Login</a></li>';
          }

          ?>

              
             
            
             

                  
                
         
        </ul>
      </div>
    </div>
  </nav>