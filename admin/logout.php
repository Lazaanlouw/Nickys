<?php
    include('../config/constants.php');
    //Query to close down the session
    session_destroy();

    //redirect to login page
    header('location:'.SITEURL.'admin/login.php');
?>