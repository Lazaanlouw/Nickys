<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>

        <br /><br />
        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset ($_SESSION['add']);
            }
            if(isset($_SESSION['remove'])){
                echo $_SESSION['remove'];
                unset ($_SESSION['remove']);
            }
            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset ($_SESSION['delete']);
            }
            if(isset($_SESSION['no-category-found'])){
                echo $_SESSION['no-category-found'];
                unset ($_SESSION['no-category-found']);
            }
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset ($_SESSION['update']);
            }
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }
            if(isset($_SESSION['failed-remove'])){
                echo $_SESSION['failed-remove'];
                unset ($_SESSION['failed-remove']);
            }
        ?>
        <br><br>
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
        <br /><br /><br />
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Image</th>
                <th>Feature</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
                <?php
                        //to get all data from the db
                        $sql = "SELECT * FROM tbl_category";

                        //Execute the query
                        $res = mysqli_query($conn, $sql);

                        //Count the rows
                        $count = mysqli_num_rows($res);

                        //Create serial Number Variable

                        $sn=1;

                        //Check whether if we have data in db
                        if($count>0){
                            //we have data
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id= $row['id'];
                                $title = $row['title'];
                                $image_name = $row['image_name'];
                                $feature= $row['feature'];
                                $active = $row['active'];

                                ?>
                                  <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td>
                                        <?php
                                            if($image_name!=""){
                                                //Display the image
                                                ?>
                                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px">

                                                <?php
                                            }else{
                                                //display the error message
                                                echo "<div class='error'>No image available</div>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $feature; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }else{
                            //we do not have data
                            //Display the message inside table
                            ?>
                            <tr>
                                <td colspan="6">
                                    <div class="error">No Category is added.</div>
                                </td>
                            </tr>
                            <?php
                        }
                ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>