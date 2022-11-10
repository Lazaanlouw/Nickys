<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Food</h1>
            <br><br>

            <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    $sql = "SELECT * FROM tbl_food WHERE id=$id";

                    //3. Execute the Query
                    $res = mysqli_query($conn, $sql);
                    $row2 = mysqli_fetch_assoc($res);


                    $title = $row2['title'];
                    $description = $row2['description'];
                    $price = $row2['price'];
                    $current_image = $row2['image_name'];
                    $current_category = $row2['category_id'];
                    $feature = $row2['feature'];
                    $active = $row2['active'];

                    //4. check if query is executed or not
                
                    // if ($res == TRUE) {
                    //     //Check if the query was executed successfully
                    //     $count = mysqli_num_rows($res);
                    //     //check whether we have data or not
                    //     if ($count == 1) {
                    //         //Get Details
                    //         // echo "Admin is available";
                    //         $row = mysqli_fetch_assoc($res);

                    //         $title = $row['title'];
                    //         $description = $row['description'];
                    //         $price = $row['price'];
                    //         $current_image = $row['image_name'];
                    //         $category = $row['category_id'];
                    //         $feature = $row['feature'];
                    //         $active = $row['active'];
                    //     } else {
                    //         $_SESSION['no-food-found'] = "<div class='error'>Food is not found.</div>";
                    //         //Redirect to Manage Admin
                    //         header('location:' . SITEURL . 'admin/manage-food.php');
                    //     }
                    // }
                } else {
                    header('location:' . SITEURL . 'admin/manage-food.php');
                }
            ?>


            <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            //Display the image
                        ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px">
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
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                                //Fetching data from the db to display categories section

                                //1. Sql to get active categories
                                    $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";
                                    $res2 = mysqli_query($conn, $sql2);

                                //2.Count rows to see if we have categories or not
                                    $count = mysqli_num_rows($res2);

                                    if($count>0){
                                        //There is data
                                        while($row=mysqli_fetch_assoc($res2)){
                                            
                                            //Getting the details of category
                                            $category_id = $row['id'];
                                            $category_title = $row['title'];

                                            ?>
                                <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                <?php
                                            }
                                        }else{
                                            //There is no data
                                            ?>
                                <option value="0">No Category Found</option>
                                <?php
                                        }     
                            ?>
                        </select>
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
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary"
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
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
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
                        $image_name = "Food-Name".rand(000, 999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/food/" . $image_name;

                        //Upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Chech whether the image is uploaded
                        if ($upload==false) {
                            //Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop the process
                            die();
                        }
                        //remove image if available
                        if ($current_image!="") {

                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //check whether the image is removed or not
                            if ($remove==false) {
                                //failed to remove the image
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove image.</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();
                            }

                        }


                    } else {
                        $image_name = $current_image;
                    }

                } else {
                    $image_name = $current_image;
                }

                //create a sql query to update admin
                $sql3 = "UPDATE tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        feature = '$feature',
                        active = '$active' 
                        WHERE id='$id'
                        ";

                //Execute the query
                $res3 = mysqli_query($conn, $sql3);

                //Check if the query was execute
                if ($res3 == TRUE) {
                    //Query Executed
                    $_SESSION['update'] = "<div class='success'>Food is updated Successfully</div>";
                    //Redirect to manage Food Page
                    header('location:' . SITEURL . 'admin/manage-food.php');
                } else {
                    //Failed to update food
                    $_SESSION['update'] = "<div class='error'>Failed to update Food</div>";
                    //Redirect to manage Food Page
                    header('location:' . SITEURL . 'admin/manage-food.php');
                }
            }

            ?>


        </div>
    </div>

<?php include('partials/footer.php'); ?>