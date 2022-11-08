<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        <?php 
            if(isset($_GET['id'])){
                    $id=$_GET['id'];
            }       
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Please enter your current password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="Please enter your new password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td><input type="password" name="confirm_password" placeholder="Confirm new password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary" style="float: right">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    //CHeck whether the submit button is clicked or not
    if(isset($_POST['submit'])){
        // echo "Button is clicked;"
        //1. get data from form
        $id=$_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //2. Check if the admin and the password exists
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
        //execute the query
        $res = mysqli_query($conn, $sql);

        if($res==TRUE){
            //Check whether the data is available
            $count=mysqli_num_rows($res);

            if($count==1){
                //user exists and password can be change
                if($new_password==$confirm_password){
                    //update password
                    // echo "Password Matched";
                    $sql2 = "UPDATE tbl_admin SET
                        password='$new_password' 
                        WHERE id=$id
                    ";

                    //Execute the query

                    $res2 = mysqli_query($conn, $sql);
                    
                    if($res2==TRUE){
                        //Display Success Message
                        $_SESSION['change-pass'] = "<div class='success'> Password changed successfully. </div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }else{

                        //Display error message
                        $_SESSION['change-pass'] = "<div class='error'> Password not changed. </div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }else{
                    $_SESSION['password-not-match'] = "<div class='error'> Password does not match. </div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //User does not exist
                //set message and redirect
                $_SESSION['user-not-found'] = "<div class='error'> User Not Found. </div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        //3. check if new and old password matches
        //4. change password if all above is true
    }
?>


<?php include('partials/footer.php'); ?>
