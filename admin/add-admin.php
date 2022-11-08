<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php 
                
                    if(isset($_SESSION['add'])){
                        echo $_SESSION['add'];//Displays that the admin was added on this page 
                        unset($_SESSION['add']);//Removes the message from page
                    }
                ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Enter your Username"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary" style="float: right">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 
    //process the value from form and save it in database
    //Check whether the submit button is clicked or not

    if(isset($_POST['submit'])){
        //Button Clicked
        // echo "Button Clicked";

        //1. Get data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);// Encryption on password with md5


        //2. SQL query to save the data into database
        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'       
        ";

        //3. Executing Query and saving data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //4. check if the query is executed or not
        if($res==TRUE){
            //data inserted
            //echo "data is inserted";
            //Creat a session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
            
            //Redirect Page to manage admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //Creat a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to Added admin</div>";
            
            //Redirect Page to manage admin
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }
?>