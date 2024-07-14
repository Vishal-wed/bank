<?php
    session_start();
    include "templets/_dbconnect.php";
    include "email/test.php";
    if(!isset($_SESSION['login'])){
        header("location: login.php");
    }
    else{
        $id = $_SESSION['id'];
        $username = $_SESSION['username'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/transfer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        /* body{
            background-image: url(pic/index_back2.jpg);
            background-size: cover;
        } */
        .card2{
            background-image: url(pic/bg6.jpg);
            background-size: cover;
        }
    </style>

</head>
<body>

<?php
    if(isset($_POST['amount'])){

        #error function

        function error_display($error, $color = "red"){
                echo '<div style="background-color: '.$color.';" class="error_noti">
                    <i class="bx bx-error"></i>
                    <span>
                        '.$error.'
                    </span>
                    <i class="bx bx-x icon2"></i>
                </div>';
        }

        #class for cut & add_money
            #cut money for user
            function user_money($money, $username, $receiver_id, $mail){
                #to store money
                global $id, $conn;
                $user_store_money = "SELECT * FROM `money_bank` WHERE `account_id` = '$id';";
                $result_user_money = mysqli_query($conn, $user_store_money);
                $user_money_row = mysqli_num_rows($result_user_money);

                if($user_money_row == 1){
                    while($row = mysqli_fetch_assoc($result_user_money)){
                        
                        if($money > 0){
                            if($money <= $row['amount']){
                                #cut money
                                $new_amount = $row['amount'] - $money;
                                $user_cut_money = "UPDATE `money_bank` SET `amount`='$new_amount' WHERE `account_id` = '$id';";
                                $result_cut_money = mysqli_query($conn, $user_cut_money);   

                                // #send mail
                                // $title = "Transfer Money";
                                // $desc = "You paid ".$money." to ".$username;

                                // mail_sender($_SESSION["email"], $title, $desc);

                                #entey in history
                                $date = date('Y-m-d H:i:s');
                                $entery = "INSERT INTO `history`(`account_id`, `paymant_status`, `desc`, `time`, `amount`) VALUES ('$id','Debited','Money Sended to $username','$date','$money');";
                                $result_entery = mysqli_query($conn, $entery);
                                receiver_money($receiver_id, $money, $mail);

                            }
                            else{
                                $error =  "not have much money in you account";
                                error_display($error);
                            }
                        }
                        else{
                            $error = "invalid amount";
                            error_display($error);
                        }
                    }
                }
                else{
                    header("location: login.php");
                }
            }

            #add money in receiver account
            function receiver_money($receiver_id, $money, $mail){

                global $id, $conn;
                $receiver_store_money = "SELECT * FROM `money_bank` WHERE `account_id` = '$receiver_id';";
                $result_receiver_money = mysqli_query($conn, $receiver_store_money);
                $receiver_money_row = mysqli_num_rows($result_receiver_money);

                if($receiver_money_row == 1){
                    while($row = mysqli_fetch_assoc($result_receiver_money)){

                        #add money
                        $new_amount = $row['amount'] + $money;
                        $receiver_add_money = "UPDATE `money_bank` SET `amount`='$new_amount' WHERE `account_id` = '$receiver_id';";
                        $result_add_money = mysqli_query($conn, $receiver_add_money);

                        #send mail          
                        $title = "Transfer Money";
                        $desc = "You have successfully received ".$money." from ".$_SESSION['username'];

                        mail_sender($mail,$title, $desc);

                        #entey in history
                        $sender_username = $_SESSION['username'];
                        $date = date('Y-m-d H:i:s');
                        $entery = "INSERT INTO `history`(`account_id`, `paymant_status`, `desc`, `time`, `amount`) VALUES ('$receiver_id','Credited','Money Sended by $sender_username','$date','$money');";
                        $result_entery = mysqli_query($conn, $entery);

                        $error = "Payment Successfully";
                        error_display($error,"green");
                    }
                }
            }

        
        #check receiver user
        function user_check($username, $mail, $money){
            global $conn;

            #user check
            $check_user = "SELECT * FROM `money_bank` WHERE `username` = '$username';";
            $result_user = mysqli_query($conn, $check_user);
            $user_row = mysqli_num_rows($result_user);

            if($user_row == 1){
                while($row = mysqli_fetch_assoc($result_user)){
                    $receiver_id = $row['account_id'];
                    #chech e-mail
                    $chech_mail = "SELECT * FROM `persnol` WHERE `account_id` = '$receiver_id';";
                    $result_mail = mysqli_query($conn, $chech_mail);
                    $mail_row = mysqli_num_rows($result_mail);

                    if($mail_row == 1){
                        while($row2 = mysqli_fetch_assoc($result_mail)){
                            if($mail == $row2['email']){
                                user_money($money, $username, $receiver_id, $mail);
                            }
                            else{
                                $error =  "invalid e-mail";
                                error_display($error);
                            }
                        }
                    }
                    else{
                        $error =  "invalid e-mail";
                        error_display($error);
                    }
                }
            }
            else{
                $error =  "invalid username";
                error_display($error);
            }
        }


        #main
        $username = $_POST['username'];
        $mail = $_POST['email'];
        $money = $_POST['amount'];


        user_check($username, $mail, $money);
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

        <div class="input_line">

            <div class="title_line">
                <p>Transfer Money</p>
            </div>

            <form action="transfer.php" method="post">
                <div class="line1">
                    <span>
                        <p class="text">Username</p>
                        <input type="text" placeholder="Receiver Username" name="username" required>
                    </span>
                </div>

                <div class="line1">
                    <span>
                        <p class="text">E-mail</p>
                        <input type="email" placeholder="Receiver E-mail" name="email" required>
                    </span>
                </div>

                <div class="line1">
                    <span>
                        <p class="text">Amount</p>
                        <input type="number" placeholder="Enter amount" name="amount" required>
                    </span>
                </div>

                <button id="sub">Submit</button>
            </form>

            <a href="index.php">
                <button id="back">Back</button>
            </a>
            
        </div>
    </div>
</body>
</html>