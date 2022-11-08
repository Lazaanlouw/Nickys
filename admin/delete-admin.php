<?php 

    // Include constants.php file here
    include('../config/constants.php'); 


    //1. Get ID of admin to delete
    $id = $_GET['id'];
    //2. Create SQL to Delete Admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //EXECUTE the query
    $res = mysqli_query($conn, $sql);

    //Check whether the query executed successfully
    if($res==TRUE){
        //Query executed successfully
        // echo "admin deleted";
        //Creating a session variable to display the message
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
        //Redirect to Manage Admin Page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //Failed to delete admin
        // echo "failed to delete admin";
        $_SESSION['delete'] = "<div class='error'>Failed to delete Admin. Try Again Later.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    
    //3. Redirect to manage admin page


?>