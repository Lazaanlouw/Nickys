<?php 
       //Start session
       session_start(); 
        
        
        //Create constant to store non repeating values
        define('SITEURL', 'http://localhost/Nickys/');
        define('LOCALHOST', 'localhost');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'nickys-food');


        
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn)); //database connection
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));//selecting the database
      

    
?>