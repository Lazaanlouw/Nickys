<?php 

      // Include constants.php file here
      include('../config/constants.php'); 


        if(isset($_GET['id']) AND isset($_GET['image_name'])){
            $id = $_GET['id'];
            $image_name = $_GET['image_name'];

            if($image_name != ""){
                //Image is available
                $path = "../images/category/".$image_name;
                $remove = unlink($path);

                if($remove == FALSE){
                    $_SESSION['remove'] = "<div class='error'>Failed to remove category image</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                    die();
                }
            }
            // Create SQL to Delete
                $sql = "DELETE FROM tbl_category WHERE id=$id";
            //EXECUTE the query
                $res = mysqli_query($conn, $sql);

            //Check whether the query executed successfully
                if($res==TRUE){
                    //Query executed successfully
                    // echo "category deleted";
                    //Creating a session variable to display the message
                    $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
                    //Redirect to Manage Category Page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Failed to delete Category
                    // echo "failed to delete Category";
                    $_SESSION['delete'] = "<div class='error'>Failed to delete Category. Try Again Later.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

        }else{
            
            header('location:'.SITEURL.'admin/manage-category.php');
        }

?>