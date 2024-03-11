<?php

    include '../php/config.php';

    if(isset($_POST['submit'])){

        $name = mysqli_real_escape_string($conn, $_POST['name']);    
        $email = mysqli_real_escape_string($conn, $_POST['email']);    
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));    
        $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploadedImages/'.$image;

        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email' AND 
        password='$password'") or die('query failed');

        if(mysqli_num_rows($select) > 0){
            $message[] = 'user already exists';
        }else {
            if($password != $cpass) {
                $message[] = 'Passwords do not match';
            }elseif($image_size > 20000000){
                $message[] = 'image format size is too large'; 
            }else {
                $insert = mysqli_query($conn, "INSERT INTO `user_form` (name, email, password, image)
         VALUES ('$name', '$email', '$password', '$image')") or die(mysqli_error($conn));


                if($insert){
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $message[] = 'registerd successfully'; 
                    header('location:login.php');

                }else{
                    $message[] = 'registration failed'; 
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- css file link  -->
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>

    <div class="form-container">

    <form action="" method="post" enctype="multipart/form-data">
        <h3>register now</h3>

        <?php
            if(isset($message)){
                foreach($message as $message) {
                    echo '<div class="message">'.$message.'</div>';
                }
            }
        ?>

        <input type="text" placeholder="enter username" required name="name" class="box">
        <input type="email" placeholder="enter email" required name="email" class="box">
        <input type="password" placeholder="enter password" required name="password" class="box">
        <input type="password" placeholder="confirm password" required name="cpassword" class="box">

        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        <input type="submit" name="submit" value="register now" class="btn" >
        <p>Already has an account <a href="login.php">Login now</a></p>

    </form>
    </div>
    
</body>
</html>