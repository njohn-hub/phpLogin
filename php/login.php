<?php

    include '../php/config.php';
    session_start();

    if(isset($_POST['submit'])){

        $email = mysqli_real_escape_string($conn, $_POST['email']);    
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));    

        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email' AND 
        password='$password'") or die('query failed');

        if(mysqli_num_rows($select) > 0){
            $row = mysqli_fetch_assoc($select);
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
            }else {
                $message[] = 'incorrect credentials';
            }
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- css file link  -->
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>

    <div class="form-container">

    <form action="" method="post" enctype="multipart/form-data">
        <h3>Login now</h3>

        <?php
            if(isset($message)){
                foreach($message as $message) {
                    echo '<div class="message">'.$message.'</div>';
                }
            }
        ?>

        <input type="email" placeholder="enter email" required name="email" class="box">
        <input type="password" placeholder="enter password" required name="password" class="box">

        <input type="submit" name="submit" value="login now" class="btn" >
        <p>Don't have an account <a href="register.php">Register now</a></p>

    </form>
    </div>
    
</body>
</html>