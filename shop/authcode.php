<?php 
session_start();
 $servername="localhost";
$username="root";
$password="";
$dbname="midb";

$conn = new mysqli($servername,$username,$password,$dbname);
if ($conn->connect_error){

	die("connection failed :".$conn->connect_error);

}
include('myfunction.php');

 if(isset($_POST['register_btn']))
{
	$name = mysqli_real_escape_string($conn,$_POST['name']);
	$phone = mysqli_real_escape_string($conn,$_POST['phone']);
	$email = mysqli_real_escape_string($conn,$_POST['email']);
	$password = mysqli_real_escape_string($conn,$_POST['password']);
	$cpassword = mysqli_real_escape_string($conn,$_POST['cpassword']);

if($password == $cpassword)
{
    $insert_query = "INSERT INTO users (name,email,phone,password) VALUES('$name','$email','$phone','$password')";
    $insert_query_run = mysqli_query($conn, $insert_query);

    if($insert_query_run)
    {
	$_SESSION['message'] = "Registerd Successfully";
	header('location: login.php');
	 }

else { 

$_SESSION['message'] = "Something went wrong";
	header('location: register.php');
     }
}

else
{
	$_SESSION['message'] = "passwords do not match";
	header ('location: register.php');
}

}
else if (isset($_POST['login_btn'])) 
{
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);

   $login_query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' ";
   $login_query_run = mysqli_query($conn , $login_query);


   if(mysqli_num_rows($login_query_run) > 0)
   {
   	$_SESSION['auth'] = true;

   	$userdata = mysqli_fetch_array($login_query_run);
   	$username = $userdata['name'];
   	$useremail = $userdata['email'];
   	$role_as = $userdata['role_as'];


   	$_SESSION['auth_user'] = [
   		'name' => $username,
   		'email' => $useremail


   	];

   	$_SESSION['role_as'] = $role_as;

   	if($role_as == 1) 
   	{
   		redirect("Admin/index.php" ,"Welcome to Dashboard" );

   	}
   	else {
   		redirect(" inddex.php" ," logged in Successfully" );
   }
}
   else 
{
	redirect("login.php" ,"invalid Information ");
	
}


}









?>