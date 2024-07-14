<?php
    session_start();
    include "templets/_dbconnect.php";
    include "email/test.php";
    $error_condition = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/forgot.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php

        function error_display($error, $color="red"){
            echo '<div style="background_color: '.$color.';" class="error_noti">
                <i class="bx bx-error"></i>
                <span>
                    '.$error.'  
                </span>
                <i class="bx bx-x icon2"></i>
            </div>';
        }

        #find email
        function email_finder($id){
            global $conn;
            $find_email = "SELECT * FROM `persnol` WHERE `account_id` = '$id';";
            $email_result = mysqli_query($conn, $find_email);
            $email_row = mysqli_num_rows($email_result);
            
            if($email_row > 0){
                while($row = mysqli_fetch_assoc($email_result)){
                    $rand = rand(0000,9999);    
                    mail_sender($row['email'], 'Forgot Password', "Your OTP : $rand. do not share OTP to other.");
                    return $rand;
                }
            }
        }
        
        if(isset($_POST['username'])){
            $username = $_POST['username'];
            $find_username = "SELECT * FROM `money_bank` WHERE `username` = '$username';";
            $user_result = mysqli_query($conn, $find_username);
            $user_row = mysqli_num_rows($user_result);
            
            if($user_row > 0){
                while($row = mysqli_fetch_assoc($user_result)){
                    $_SESSION['temp_id'] = $row['account_id'];
                    $_SESSION['otp'] = email_finder($row["account_id"]);
                }
            }
            else{
                $error = "Username not found";
                error_display($error);
                $error_condition = 1;
            }
        }
    ?>

    <?php
        if(isset($_POST['otp'])){
            $re_otp = $_POST['otp'];
            if($_SESSION['otp'] == $re_otp){
                $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $id = $_SESSION['temp_id'];
                $update_password = "UPDATE `money_bank` SET `user_password`='$new_password' WHERE `account_id` = '$id';";
                $result_update = mysqli_query($conn, $update_password);
                header("location: index.php");
            }
            else{
                $error = "Wrong OTP";
                error_display($error);
            }
        }
    ?>


    <form action="forgot.php" method="post">
        <div class="card">
            <p class="header">Forgot Password</p>

            <?php
                if(!isset($_POST['submit']) || $error_condition == 1){
                    echo '
                        <span class="line">
                        <p id="user_name" class="header_text">Username</p>
                        <input type="text" name="username" required>
                        </span>
                    ';
                }
            ?>
    
            <?php
                if(isset($_POST['submit']) && $error_condition == 0){
                    echo '
                        <span class="line">
                        <p id="otp" class="header_text">OTP</p>
                        <input type="number" name="otp" required>
                        </span>
                    ';

                    echo '
                        <span class="line">
                        <p id="otp" class="header_text">New Password</p>
                        <input type="password" name="password" required>
                        </span>
                    ';
                }
            ?>
    
            <span class="line">
                <button type="submit" name="submit" id="sub">submit</button>
            </span>
        </div>
    </form>
</body>
</html>