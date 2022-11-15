 <?php include('partials-front/menu.php'); ?>
    <!-- Navbar Section Ends Here -->



    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->
    <?php
    if(isset($_SESSION['order'])){
        echo $_SESSION['order'];
        unset ($_SESSION['order']);
    }
    ?>
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php

                //Create Sql query to display categories from db
                $sql = "SELECT * FROM tbl_category WHERE active='YES' && feature='Yes' LIMIT 3";

                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if($count>0){
                    
                    //we got data
                    while($row=mysqli_fetch_assoc($res)){
                        $id= $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];

                        ?>
                        
                            <a href="<?php SITEURL;?>category-foods.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php 
                                    //check whether image is available
                                        if($image_name==""){
                                            echo "<div class='error'>Image is not available</div>";
                                        }else{

                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                            <?php

                                        }
                                    ?>

                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                </div>
                            </a>
                        <?php
                    }
                    
                }else{
                    //we dont have data
                    echo "<div class='error'>Category is not added.</div>";
                }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            
                //Get all food from db that are active and feature
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' && feature='yes' LIMIT 6";

                $res2 = mysqli_query($conn, $sql2);

                $count2 = mysqli_num_rows($res2);

                if($count2>0){
                    //we have data
                    while($row=mysqli_fetch_assoc($res2)){
                        //Get all the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        
                        ?>


                            <div class="food-menu-box">
                                                <div class="food-menu-img">
                                                    <?php
                                                        //Check if image is available
                                                        if($image_name ==""){
                                                            echo "<div class='error'>Image is not available</div>";
                                                        }else{
                                                            ?>
                                                                 <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                                            <?php
                                                        }
                                                    ?>
                                                </div>

                                                <div class="food-menu-desc">
                                                    <h4><?php echo $title; ?></h4>
                                                    <p class="food-price">R<?php echo $price; ?></p>
                                                    <p class="food-detail">
                                                        <?php echo $description;?>
                                                    </p>
                                                    <br>

                                                    <a href="<?php echo SITEURL;?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                                                </div>
                                            </div>

                        <?php
                    }
                }else{
                    //no data available
                    echo "<div class='error'>Food is not available</div>";
                }

            ?>

                
            <div class="clearfix"></div>
        </div>

        <p class="text-center">
            <a href="<?php echo SITEURL;?>foods.php">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?> 