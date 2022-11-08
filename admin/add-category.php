<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>
        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <br><br>

        <!-- Add category form -->
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- enctype helps with uploading the image -->

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
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
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary"
                            style="float: right">
                    </td>
                </tr>
            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 
    //Check whether if the button is clicked

    if(isset($_POST['submit'])){
        // echo "Button Clicked";

        //1. Get the value from the form
        $title = $_POST['title'];

        // for radio input, we need to check if user selected any of the options
        if(isset($_POST['feature'])){

            //Get the value from form
            $feature = $_POST['feature'];

        }else{
            //set default Value
            $feature = "No";
        }
        if(isset($_POST['active'])){
            
            //Get the value from form
            $active = $_POST['active'];

        }else{
            //set default Value
            $active = "No";
        }

        //check whether the image is selected or not
        // print_r($_FILES['image']);

        // die(); // breaking the code here

        if(isset($_FILES['image']['name'])){
            //Upload the image
            //1. we need image name and source path and destination path
            $image_name = $_FILES['image']['name'];

                //upload image only if image is selected

                if($image_name != ""){
                
                
                        //Auto Rename the image so it does not replace the current image in db if there is duplicates
                        //Get extension of image
                        $ext = end(explode('.', $image_name)); //explode breaks the name into sections

                        //rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    //Upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //Chech whether the image is uploaded
                    if($upload==FALSE){
                        //Set message
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                        header('location:'.SITEURL.'admin/add-category.php');
                        //Stop the process
                        die();
                    }
                }else{
                    //Dont upload image and set the image name value as blank
                    $image_name="";
                }
        }

        //2. Sql query to insert value into db
        $sql = "INSERT INTO tbl_category SET
            title='$title',
            image_name='$image_name',
            feature='$feature',
            active='$active'
        ";

        //3. Execute query and save in db
        $res = mysqli_query($conn, $sql);

        //4. Check if query was executed
        if($res==TRUE){
            //Query executed and new category is created
            $_SESSION['add'] = "<div class='sucess'>Category Added Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }else{
            //Failed to add new category
            $_SESSION['add'] = "<div class='error'>Failed to add new category.</div>";
            header('location:'.SITEURL.'admin/add-category.php');

        }
    }

?>