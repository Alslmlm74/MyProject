<?php 
include ('../myfunction.php');


if (isset($_SESSION['auth'])) 
{
if($_SESSION['role_as'] != 1)
{
	redirect("../indexx.php" , "You are not authorized to access this page");
}

}
else
{
	redirect("../login.php" , "login to continue...");
	 
}

?>