<?php
    include('../config/constants.php');

?>

<html>

<head>
    <title>Login - Nickys Food</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>


<body>
    <div class="login">
        <h1 class="text-center" style=" 
    color: #8395a7;">Login</h1>
    <br>

        <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>

        <br><br>

        <!-- Login form  -->
        <form action="" method="POST">
            <a style="color: #8395a7;">Username: </a> <br>
            <input type="text" name="username" placeholder="Please enter your Username"><br><br>

            <a style="color: #8395a7;">Password: </a> <br>
            <input type="password" name="password" placeholder="Please enter your password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary" style="width: 40%;">
        </form>

        <br><br>
        <p> <a style="color: #8395a7;">Created by -</a> <a href="#">Lezaan Louw</a></p>
    </div>
</body>

</html>

<?php 

    //Check if the submit button is clicked
    if(isset($_POST['submit'])){
        //Process for Login
        //1. Get data from Login Form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. Sql Query to check whether the user and pass exists
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute the query

        $res = mysqli_query($conn, $sql);

        //4. Count rows o see if there is users in the db
        $count = mysqli_num_rows($res);

        if($count==1){

            //User is available
            $_SESSION['login'] = "<div class='success'> Login is Successful.</div>";
            $_SESSION['user'] = $username;// To check whether the user is logged in or not

            header('location:'.SITEURL.'admin/index.php');
        }else{

            //User not available
            $_SESSION['login'] = "<div class='error text-center'> Username and password did not match.</div>";
            header('location:'.SITEURL.'admin/login.php');
        }
    }

?>