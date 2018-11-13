<?php

//include ('layouts/header.php');
include ('process.php');
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

<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    
                   
                    <form class="form-horizontal" method="POST" action="process.php">
                        

                        <div class="form-group">
                            <label for="userID" class="col-md-4 control-label">User ID</label>

                            <div class="col-md-6">
                                <input id="userID" type="userID" class="form-control" name="userID" value="" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" name="login" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="#">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br><br><br><br><br><br><br>

<?php 
include ('layouts/footer.php');
?>
