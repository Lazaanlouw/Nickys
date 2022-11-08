<?php 
    include('../config/constants.php');
    include('authorisation.php');
    
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<html>
    <head>
        <title>
            Nickys Food - Home Page
        </title>

        <!-- this links the css folder -->
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <!-- Menu content section -->
        <div class="menu  text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-category.php">Category</a></li>
                    <li><a href="manage-food.php">Food</a></li>
                    <li><a href="manage-order.php">Order</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                    <!-- <li><a href="#">Contact Us</a></li> -->
                </ul>
            </div>

        </div>