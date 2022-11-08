<?php include('partials/menu.php'); ?>

<!-- Main content section -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br />

        <?php 
                
                    if(isset($_SESSION['add'])){
                        echo $_SESSION['add'];//Displays that the admin was added on this page 
                        unset($_SESSION['add']);//Removes the message from page
                    }

                    if(isset($_SESSION['delete'])){
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update'])){
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                    
                    if(isset($_SESSION['user-not-found'])){
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }
                    if(isset($_SESSION['password-not-match'])){
                        echo $_SESSION['password-not-match'];
                        unset($_SESSION['password-not-match']);
                    }
                    if(isset($_SESSION['change-pass'])){
                        echo $_SESSION['change-pass'];
                        unset($_SESSION['change-pass']);
                    }
                ?>
        <br>
        <br>
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
                        //Query to get all admins
                        $sql = "SELECT * FROM tbl_admin";
                        
                        //Execute the query
                        $res = mysqli_query($conn, $sql);

                        //Check whether the query is executed or not
                        if($res==TRUE){
                            //check if we have data
                            $count = mysqli_num_rows($res);

                            $sn=1;//created a variable and assigned it

                            if($count>0){
                                //we have data
                                while($rows=mysqli_fetch_assoc($res))
                            {
                                //using while loop to get all the data from DB
                                //get individual data
                                $id=$rows['id'];
                                $full_name=$rows['full_name'];
                                $username=$rows['username'];

                                //display the values in the table
                                ?>

            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $full_name; ?></td>
                <td><?php echo $username; ?></td>
                <td>
                    <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>"
                        class="btn-primary">Change Password</a>
                    <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>"
                        class="btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger"><i
                            class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>

            <?php
                            }
                            }else{
                                //we do not have data in database

                                echo "There is no data in the Database";
                            }
                        }
                    ?>
        </table>
    </div>

</div>

<?php include('partials/footer.php'); ?>