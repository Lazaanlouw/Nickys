<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php 
        
            //Display the current details of admin
            //1. Get ID of Admin
                $id=$_GET['id'];
            //2. Create SQL query to get details
                $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            //3. Execute the Query
                $res=mysqli_query($conn, $sql);    

            //4. check if query is executed or not

            if($res==TRUE){
                //Check if the query was executed successfully
                $count = mysqli_num_rows($res);
                //check whether we have data or not
                if($count==1){
                    //Get Details
                    // echo "Admin is available";
                    $row=mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }else{
                    //Redirect to Manage Admin
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name; ?>"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary" style="float: right">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php

        //Check whether the submit button is clicked or not
        if(isset($_POST['submit'])){
            //echo "Button clicked";
            //Get all the values from the form to update
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $username = $_POST['username'];

            //create a sql query to update admin
            $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username' 
            WHERE id='$id'
            ";

            //Execute the query
            $res = mysqli_query($conn, $sql);
 
            //Check if the query was execute
            if($res==TRUE){
                //Query Executed
                $_SESSION['update'] = "<div class='success'>Admin updated Successfully</div>";
                //Redirect to manage Admin Page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }else{
                //Failed to update admin
                $_SESSION['update'] = "<div class='error'>Failed to update Admin</div>";
                //Redirect to manage Admin Page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }

?>

<?php include('partials/footer.php'); ?>