<?php 
session_start();
include('../myfunction.php');
 $servername="localhost";
$username="root";
$password="";
$dbname="midb";

$conn = new mysqli($servername,$username,$password,$dbname);
if ($conn->connect_error){

	die("connection failed :".$conn->connect_error);

}

if(isset($_POST['add-category-btn']))
{
	
	$name = $_POST['name'];
	$slug = $_POST['slug'];
	$description = $_POST['description'];
	$meta_title = $_POST['meta_title'];
	$meta_description = $_POST['meta_description'];
	$meta_keywords = $_POST['meta_keywords'];
	$status = isset($_POST['status']) ? '1' : '0';
	$popular =isset($_POST['popular']) ? '1' : '0';

	$image = $_FILES['image']['name'];

	$path = "../uploads";

	$image_ext = pathinfo($image , PATHINFO_EXTENSION);
	$filename = time().'.'.$image_ext;


    $cate_query = "INSERT INTO categories
    (name,slug,description, meta_title, meta_description,meta_keywords,status,popular,image)
    VALUES ('$name', '$slug', '$description', '$meta_title' , '$meta_description ', '$meta_keywords','$status', '$popular', '$filename')";

    $cate_query_run = mysqli_query($conn,$cate_query);

    if($cate_query_run)
    {
    move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename);


   redirect("add-category.php", "Category Added Successfully!!");

    }
    else
    {
redirect("add-category.php", "Something Went Wrong !!");
    }

}
else if(isset($_POST['update-category-btn']))
{

    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
	$slug = $_POST['slug'];
	$description = $_POST['description'];
	$meta_title = $_POST['meta_title'];
	$meta_description = $_POST['meta_description'];
	$meta_keywords = $_POST['meta_keywords'];
	$status = isset($_POST['status']) ? '1' : '0';
	$popular =isset($_POST['popular']) ? '1' : '0';

	$new_image = $_FILES['image']['name'];
	$old_image = $_POST['old_image'];

	if($new_image != "")
	{
		//$update_filename = $new_image;
		$image_ext = pathinfo($new_image , PATHINFO_EXTENSION);
	$update_filename = time().'.'.$image_ext;

	}

    else {
    	$update_filename = $old_image;
    }
    $path = "../uploads";
    $update_query = "UPDATE categories SET name='$name', slug='$slug',description='$description',meta_title='$meta_title',  meta_description='$meta_description', meta_keywords='$meta_keywords',status='$status', popular='$popular', image= '$update_filename' WHERE id='$category_id' ";

  $update_query_run = mysqli_query($conn, $update_query);

  if($update_query_run)
  {
  	if ($_FILES['image']['name'] != "")
  	{
  		move_uploaded_file($_FILES['image']['tmp_name'],$path.'/'.$update_filename);
  		if(file_exists("../uploads/".$old_image))
  		{
  			unlink("../uploads/".$old_image);
  		}
  	}
  	redirect("edit-category.php?id=$category_id" , "Category updated Successfully");
  }
  else 
  {
  	redirect("edit-category.php?id=$category_id" , "Something Went Wrong");
  }


}
else if (isset($_POST['delete-category-btn']))
{

	$category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    $category_query= "SELECT * FROM categories WHERE id='$category_id' ";
    $category_query_run = mysqli_query($conn, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image = $category_data['image'];

	$delete_query = "DELETE FROM categories WHERE id= '$category_id' ";
	$delete_query_run = mysqli_query($conn, $delete_query);
	 

	if($delete_query_run)

     {
     	if(file_exists("../uploads/".$image))
  		{
  			unlink("../uploads/".$image);
  		}
	redirect("category.php" , "The Category has been deleted");

     }
     else
     {
     redirect("category.php" , "Opps Something Went Wrong");
     }
 }
 


 else if(isset($_POST['add-products-btn']))
      
 {  

    $category_id = $_POST['category_id'];

    $name = $_POST['name'];
	$slug = $_POST['slug'];
	$small_description = $_POST['small_description'];
	$description = $_POST['description'];
	$original_price =$_POST['original_price'];
	$selling_price =$_POST['selling_price'];
	$qty = $_POST['qty'];
	$meta_title = $_POST['meta_title'];
	$meta_description = $_POST['meta_description'];
	$meta_keywords = $_POST['meta_keywords'];
	$status = isset($_POST['status']) ? '1' : '0';
	$trending =isset($_POST['trending']) ? '1' : '0';

	$image = $_FILES['image']['name'];

	$path = "../uploads";

	$image_ext = pathinfo($image , PATHINFO_EXTENSION);
	$filename = time().'.'.$image_ext;
     
     $product_query = "INSERT INTO products(category_id,name,slug,small_description,description, original_price, selling_price,qty,meta_title, meta_description,meta_keywords,status,trending ,image) VALUES ('$category_id','$name', '$slug','$small_description'  ,'$description', '$original_price', '$selling_price','$qty', '$meta_title' , '$meta_description', '$meta_keywords','$status', '$trending', '$filename') ";

     	$product_query_run = mysqli_query($conn, $product_query);

     	if($product_query_run) {
     		move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename);


   redirect("add-products.php", "Product Added Successfully!!");

    }
    else {

   redirect("add-products.php", "Something Went Wrong");
    }

}         







?>