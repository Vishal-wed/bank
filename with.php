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
    <link rel="stylesheet" href="style/with.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .card2{
            background-image: url(pic/bg6.jpg);
        }
    </style>
</head>
<body>

<?php

    if(isset($_POST['amount'])){

        #error function

        function error_display($error, $color){
                echo '<div style="background-color: '.$color.';" class="error_noti">
                    <i class="bx bx-error"></i>
                    <span>
                        '.$error.'  
                    </span>
                    <i class="bx bx-x icon2"></i>
                </div>';
        }

        #cut money form account
        class withd{

            #user account
            function user_account($money){
                global $conn, $id;
                $check_amount = "SELECT * FROM `money_bank` WHERE `account_id` = '$id';";
                $amount_result = mysqli_query($conn, $check_amount);
                $amount_row = mysqli_num_rows($amount_result);

                if($amount_row == 1){
                    while($row = mysqli_fetch_assoc($amount_result)){
                        $ori_money = $row['amount'];
                    }
                }
                $add_amount = $ori_money - $money;
                $add_money_sql = "UPDATE `money_bank` SET `amount`='$add_amount' WHERE `account_id` = '$id';";
                $result_add_money = mysqli_query($conn, $add_money_sql);
            }

        }

        #check pin
        function check($pin, $money){

            if($money > 0 ){
                global $conn, $id;
                #to store money
                $store_money = "SELECT * FROM `money_bank` WHERE `account_id` = '$id';";
                $result_money = mysqli_query($conn, $store_money);
                $money_row = mysqli_num_rows($result_money);

                if($money_row == 1){
                    while($row = mysqli_fetch_assoc($result_money)){
                        $ori_money = $row['amount'];
                    }
                }

                $chech_pin = "SELECT * FROM `account_details` WHERE `account_id` = '$id';";
                $result_pin = mysqli_query($conn, $chech_pin);
                $pin_row = mysqli_num_rows($result_pin);

                if($pin_row == 1){
                    while($row = mysqli_fetch_assoc($result_pin)){
                        if($pin == $row['pin']){
                            if($money <= $ori_money){
                                $temp = new withd();

                                $temp->user_account($money);

                                #send eamil
                                
                                $title = "Debited Money";
                                $desc = "Your A/C can be Debited with Rs".$money;

                                mail_sender($_SESSION["email"], $title, $desc);

                                #entey in history
                                $date = date('Y-m-d H:i:s');
                                $entery = "INSERT INTO `history`(`account_id`, `paymant_status`, `desc`, `time`, `amount`) VALUES ('$id','Debited','Withdrawal Money','$date','$money');";
                                $result_entery = mysqli_query($conn, $entery);
                                $error = "Withdraw successfully";
                                error_display($error, "green");
                            }
                            else{
                                $error = "not have that much amount in account";
                                error_display($error, "red");    
                            }
                        }
                        else{
                            $error =  "wrong pin";
                            error_display($error, "red");
                        }
                    }
                }
            }
            else{
                $error = "Invalid Amount";
                error_display($error, "red");
            }
        }

        #main
        $pin = $_POST['Pin'];
        $money = $_POST['amount'];

        check($pin, $money);

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
                <p><?php echo ucwords($account_holder);?></p>
            </div>
    
            <div class="last">
                <span>
                    <p>Amount</p>
                    <p><?php echo $money ?>.00</p>
                </span>
    
                <img src="pic/logo.png" class="logo">
            </div>
        </div>

        <div id="line_input">

            <form action="with.php" method="post">
                <div>
                    <span>
                        <p class="text">Pin</p>
                        <input type="password" name="Pin" required>
                    </span>
                </div>

                <div id="amount_margin">
                    <span>
                        <p class="text">Amount</p>
                        <input type="number" name="amount" required>
                    </span>
                </div>
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