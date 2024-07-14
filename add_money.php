<?php
    session_start();
    include "templets/_dbconnect.php";
    include "templets/internet_connection.php";
    include "email/test.php";
    if(!isset($_SESSION["login"])){
        header("location: login.php");
    }
    else{
        $username = $_SESSION['username'];
        $id = $_SESSION['id'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/add.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .card2{
            background-image: url(pic/bg6.jpg);
            background-size: cover;
        }
    </style>

</head>
<body>

    <?php

        function error_display($error, $color="red"){
            echo '<div style="background-color: '.$color.';" class="error_noti">
                <i class="bx bx-error"></i>
                <span>
                    '.$error.'  
                </span>
                <i class="bx bx-x icon2"></i>
            </div>';
        }

        if(isset($_POST['amount'])){

            #send email

            function send_mail($amount){
                $user_email = $_SESSION['email'];
                $title = "Credited Money";
                $desc = "Your A/C can be Credited with Rs".$amount;

                mail_sender( $user_email, $title, $desc);
            }

            #check
            function check($new_amount){
                if($new_amount > 0){
                    add($new_amount);
                }
                else{
                    $error =  "invalid amount";
                    error_display($error, "red");
                }
            }

            #add money
            function add($new_amount){
                global $conn, $id;
                $store_money = "SELECT * FROM `money_bank` WHERE `account_id` = '$id';";
                $result_money = mysqli_query($conn, $store_money);
                $money_row = mysqli_num_rows($result_money);

                if($money_row == 1){
                    while($row = mysqli_fetch_assoc($result_money)){
                        $money = $row['amount'];
                    }
                }
                $add_amount = $money + $new_amount;
                $add_money_sql = "UPDATE `money_bank` SET `amount`='$add_amount' WHERE `account_id` = '$id';";
                $result_add_money = mysqli_query($conn, $add_money_sql);
                send_mail($new_amount);

                #entey in history
                $date = date('Y-m-d H:i:s');
                $entery = "INSERT INTO `history`(`account_id`, `paymant_status`, `desc`, `time`, `amount`) VALUES ('$id','Credited','Added Money','$date','$new_amount');";
                $result_entery = mysqli_query($conn, $entery);

                $error = "Money added to your account successfully";
                error_display($error, "green");
            }

            $new_amount = $_POST['amount'];
            check($new_amount);
        }

    ?>

    
    <div class="card1">
        <div class="card2">
        <?php
            #to store account_number
            $store_account_number = "SELECT * FROM `account_details` WHERE `account_id` = '$id';";
            $result_account_number = mysqli_query($conn, $store_account_number);
            $account_number_row = mysqli_num_rows($result_account_number);

            if($account_number_row == 1){
                while($row = mysqli_fetch_assoc($result_account_number)){
                    $account_number = $row['account_number'];
                }
            }

            #to store account_holder_name 
            $store_account_holder = "SELECT * FROM `persnol` WHERE `account_id` = '$id';";
            $result_account_holder = mysqli_query($conn, $store_account_holder);
            $account_holder_row = mysqli_num_rows($result_account_holder);

            if($account_holder_row == 1){
                while($row = mysqli_fetch_assoc($result_account_holder)){
                    $account_holder = $row['name'];
                }
            }

            #to store money
            $store_money = "SELECT * FROM `money_bank` WHERE `account_id` = '$id';";
            $result_money = mysqli_query($conn, $store_money);
            $money_row = mysqli_num_rows($result_money);

            if($money_row == 1){
                while($row = mysqli_fetch_assoc($result_money)){
                    $money = $row['amount'];
                }
            }

        ?>
            <div class="pic_line">
                <img class="pic" src="pic/chip.png">
                <img class="pic" src="pic/visa.png">
            </div>
    
            <div class="number_line">
                <p id="number"><?php echo $account_number; ?></p>
                <img class="pic" src="pic/wifi.png">
            </div>
    
            <div class="name_line">
                <p><?php echo ucwords($account_holder); ?></p>
            </div>
    
            <div class="last">
                <span>
                    <p>Amount</p>
                    <p><?php echo $money.".00"; ?></p>
                </span>
    
                <img src="pic/logo.png" class="logo">
            </div>
        </div>

        <div id="line_input">
            <form action="add_money.php" method="post">
                <span>
                    <p class="text">Amount</p>
                    <input type="number" name="amount" required>
                </span>
                <br>
                <button id="sub">submit</button>
            </form>
            
            <a href="index.php">
                <button id="back">back</button>
            </a>
        </div>
    </div>
</body>
</html>