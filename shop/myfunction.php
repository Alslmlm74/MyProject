<?php 
$servername="localhost";
$username="root";
$password="";
$dbname="midb";

$conn = new mysqli($servername,$username,$password,$dbname);
if ($conn->connect_error){

    die("connection failed :".$conn->connect_error);

}

function getAll($table)
 {
    global $conn;
    $query = "SELECT * FROM $table";
    return $query_run = mysqli_query($conn , $query);
 }

 function getByID($table, $id)
 {
    global $conn;
    $query = "SELECT * FROM $table WHERE id='$id' ";
    return $query_run = mysqli_query($conn , $query);
 }
 

function redirect( $url, $message)
{
	$_SESSION['message'] = $message;
    header ('location: ' .$url);
    exit();
}

?>