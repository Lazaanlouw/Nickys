<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            //3. Execute the Query
            $res = mysqli_query($conn, $sql);

            //4. check if query is executed or not
        
            if ($res == TRUE) {
                //Check if the query was executed successfully
                $count = mysqli_num_rows($res);
                //check whether we have data or not
                if ($count == 1) {
                    //Get Details
                    // echo "Category is available";
                    $row = mysqli_fetch_assoc($res);

                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $feature = $row['feature'];
                    $active = $row['active'];
                } else {
                    $_SESSION['no-category-found'] = "<div class='error'>Category is not found.</div>";
                    //Redirect to Manage Category
                    header('location:' . SITEURL . 'admin/manage-category.php');
                }
            }
        } else {
            header('location:' . SITEURL . 'admin/manage-category.php');
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            //Display the image
                        ?>
                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="100px">
                        <?php
                        } else {
                            //Display message
                            echo "<div class='error'>Image is not available</div>";
                        }
                                ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Feature: </td>
                    <td>
                        <input <?php if ($feature == "Yes") {
                            echo "checked";
                        } ?> type="radio" name="feature" value="yes">
                        Yes
                        <input <?php if ($feature == "No") {
                            echo "checked";
                        } ?> type="radio" name="feature" value="no"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                            echo "checked";
                        } ?> type="radio" name="active" value="yes"> Yes
                        <input <?php if ($active == "No") {
                            echo "checked";
                        } ?> type="radio" name="active" value="no"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary"
                            style="float: right">
                    </td>
                </tr>
            </table>
        </form>

        <?php

            //Check whether the submit button is clicked or not
            if (isset($_POST['submit'])) {
                //echo "Button clicked";
                //Get all the values from the form to update
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $feature = $_POST['feature'];
                $active = $_POST['active'];

                if (isset($_FILES['image']['name'])) {
                    $image_name = $_FILES['image']['name'];

                    if ($image_name!="") {
                        //Image available
                        //Upload the new image & remove current image
            
                        //Auto Rename the image so it does not replace the current image in db if there is duplicates
                        //Get extension of image
                        $image_info = explode (".", $image_name);
                        $ext = end ($image_info); //explode breaks the name into sections
            
                        //rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/" . $image_name;

                        //Upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Chech whether the image is uploaded
                        if ($upload==false) {
                            //Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //Stop the process
                            die();
                        }
                        //remove image if available
                        if ($current_image!="") {

                            $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);

                            //check whether the image is removed or not
                            if ($remove==false) {
                                //failed to remove the image
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove image.</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                            }

                        }


                    } else {
                        $image_name = $current_image;
                    }

                } else {
                    $image_name = $current_image;
                }

                //create a sql query to update category
                $sql2 = "UPDATE tbl_category SET
                        title = '$title',
                        image_name = '$image_name',
                        feature = '$feature',
                        active = '$active' 
                        WHERE id='$id'
                        ";

                //Execute the query
                $res2 = mysqli_query($conn, $sql2);

                //Check if the query was execute
                if ($res2 == TRUE) {
                    //Query Executed
                    $_SESSION['update'] = "<div class='success'>Category is updated Successfully</div>";
                    //Redirect to manage category Page
                    header('location:' . SITEURL . 'admin/manage-category.php');
                } else {
                    //Failed to update category
                    $_SESSION['update'] = "<div class='error'>Failed to update Category</div>";
                    //Redirect to manage category Page
                    header('location:' . SITEURL . 'admin/manage-category.php');
                }
            }

            ?>

    </div>
</div>



<?php include('partials/footer.php'); ?>