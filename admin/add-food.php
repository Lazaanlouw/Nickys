<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"
                            placeholder="Description of the food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Image: </td>
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
                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                    $res = mysqli_query($conn, $sql);

                                //2.Count rows to see if we have categories or not
                                    $count = mysqli_num_rows($res);

                                    if($count>0){
                                        //There is data
                                        while($row=mysqli_fetch_assoc($res)){
                                            
                                            //Getting the details of category
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            // $description = $row['description'];
                                            // $price = $row['price'];
                                            // $category = $row['category_id'];
                                            // $feature = $row['feature'];
                                            // $active = $row['active'];
                                            ?>
                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
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
                        <input type="radio" name="feature" value="Yes"> Yes
                        <input type="radio" name="feature" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary" style="float: right">
                    </td>
                </tr>
            </table>
        </form>
        <?php 

            //check to see if the button is clicked or not
            if(isset($_POST['submit'])){
                // echo "Button Clicked";
                //1. Get data from form

                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];
                
                //check if radio button for active and featured are checked
                    if(isset($_POST['feature'])){
                        $feature = $_POST['feature'];
                    }else{
                        $feature = "No"; //Default Value 
                    }
                    if(isset($_POST['active'])){
                        $active = $_POST['active'];
                    }else{
                        $active = "No"; //Default Value 
                    }

                //2.Upload the images if selected

                    //check whether the image is selected or not and upload
                    if(isset($_FILES['image']['name'])){
                        //Get the details of the selected images
                        $image_name = $_FILES['image']['name'];

                        //Check if the image is selected and upload only if selected
                        if($image_name != ""){
                            //Image is selected
                            // A. Rename the image
                            $image_info = explode (".", $image_name);
                            $ext = end ($image_info);

                            // B. Upload the image
                                $image_name = "Food-Name".rand(0000, 9999).'.'.$ext;

                                $source_path = $_FILES['image']['tmp_name'];
                                $destination_path = "../images/food/".$image_name;

                                //Upload the image
                                $upload = move_uploaded_file($source_path, $destination_path);

                                //Chech whether the image is uploaded
                                if($upload==FALSE){
                                    //Set message
                                    $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                                    header('location:'.SITEURL.'admin/add-food.php');
                                    //Stop the process
                                    die();
                                }
                            }
                    }else{
                        $image_name = "";
                    } 

                //3. Insert into database 

                    //Create sql query to insert data into db
                    $sql2 = "INSERT INTO tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        feature = '$feature',
                        active = '$active'
                ";

                //3. Execute query and save in db
                $res2 = mysqli_query($conn, $sql2);

                //4. Check if query was executed
                if($res2 == true){
                    //Query executed and new food is created
                    $_SESSION['add'] = "<div class='sucess'>Food was Added Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }else{
                    //Failed to add new food
                    $_SESSION['add'] = "<div class='error'>Failed to add new food.</div>";
                    header('location:'.SITEURL.'admin/add-food.php');

                }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>