<?php 

// Include constants.php file here
include('../config/constants.php'); 


if(isset($_GET['id']) && isset($_GET['image_name'])){
    //Process to Delete
    // echo "Process to Delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    if($image_name != ""){
        //Image is available
        $path = "../images/food/".$image_name;
        $remove = unlink($path);

        if($remove == FALSE){
            $_SESSION['remove'] = "<div class='error'>Failed to remove food image</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            die();
        }
    }
     // Create SQL to Delete
     $sql = "DELETE FROM tbl_food WHERE id=$id";
     //EXECUTE the query
         $res = mysqli_query($conn, $sql);

     //Check whether the query executed successfully
         if($res==TRUE){
             //Query executed successfully
             // echo "food deleted";
             //Creating a session variable to display the message
             $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
             //Redirect to Manage Food Page
             header('location:'.SITEURL.'admin/manage-food.php');
         }
         else
         {
             //Failed to delete food
             // echo "failed to delete food";
             $_SESSION['delete'] = "<div class='error'>Failed to delete Food. Try Again Later.</div>";
             header('location:'.SITEURL.'admin/manage-food.php');
         }


}else{
    //redirect to manage food page
    $_SESSION['delete'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}




?>