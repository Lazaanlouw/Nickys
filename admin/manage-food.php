<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br /><br />
        <a href="<?php echo SITEURL ;?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br /><br /><br />

        <?php
                    if(isset($_SESSION['add'])){
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }
                    if(isset($_SESSION['delete'])){
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                    if(isset($_SESSION['remove'])){
                        echo $_SESSION['remove'];
                        unset($_SESSION['remove']);
                    }
                    if(isset($_SESSION['upload'])){
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }
                    if(isset($_SESSION['failed-remove'])){
                        echo $_SESSION['failed-remove'];
                        unset($_SESSION['failed-remove']);
                    }
                    if(isset($_SESSION['update'])){
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                
                ?>
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Feature</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
            <?php
                        //Sql query to get all data for food
                        $sql = "SELECT * FROM tbl_food";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                        $sn=1;
                        if($count>0){
                            //There is data
                            //get the foods from db
                            while ($row=mysqli_fetch_assoc($res)) {
                                $id= $row['id'];
                                $title= $row['title'];
                                $description = $row['description'];
                                $price= $row['price'];
                                $image_name= $row['image_name'];
                                $feature= $row['feature'];
                                $active= $row['active'];
                                ?>

            <tr>
                <td><?php echo $sn++;?></td>
                <td><?php echo $title; ?></td>
                <td><?php echo $description; ?></td>
                <td>R<?php echo $price; ?></td>
                <td>
                    <?php
                                            if($image_name!=""){
                                                //Display the image
                                                ?>
                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">

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
                    <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name;?> " class="btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name;?>" class="btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>


            <?php
                            }
                        }else{
                            //There is no food
                            echo "<tr> <td colspan='7' class='error'> Food not added yet.</td></tr>";
                        }
                    ?>

        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>