<?php
include "templets/internet_connection.php";
check_internat();
session_start();
include "templets/_dbconnect.php";
include "email/test.php";
if (!isset($_SESSION['login'])) {
    header("location: login.php");
} else {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];
}
?>

<!-- order amount -->

<?php

#error function

function error_display($error, $color = "red"){
    echo '<div style="background-color: '.$color.';" class="error_noti">
            '.$error.'
    </div>';
}

            if(isset($_POST['order_done'])){

                $amount_find = "SELECT * FROM `money_bank` WHERE `account_id` = '$id';";
                    $result_amount = mysqli_query($conn, $amount_find);
                    $row_amount = mysqli_num_rows($result_amount);

                    if ($row_amount > 0) {
                        while ($row = mysqli_fetch_assoc($result_amount)) {
                            if($row['amount'] > 399){
                                $last_amount = $row['amount'] - 399;
                                $cut_money = "UPDATE `money_bank` SET `amount`='$last_amount', `debit_card`=1 WHERE `account_id` = '$id';";
                                $result_cut_money = mysqli_query($conn, $cut_money);

                                mail_sender($_SESSION["email"], "Purchase Card", "Thank You for Purchase our debit card");

                                $date = date('Y-m-d H:i:s');
                                $entery = "INSERT INTO `history`(`account_id`, `paymant_status`, `desc`, `time`, `amount`) VALUES ('$id','Debited','Purchase Debit card','$date',399);";
                                $result_entery = mysqli_query($conn, $entery);
                                $error = "Order Successfully";
                                error_display($error, "green");
                            }
                            else{
                                $error = "You don't have much amount in account";
                                error_display($error);
                            }
                        }
                    }

            }
        ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/side_nav.css">
    <link rel="stylesheet" href="style/index.css">
    <!-- <link rel="stylesheet" href="style/demo.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .image {
            background-image: url(pic/logo.png);
            background-size: cover;
            height: 50px;
        }
    </style>
</head>

<body>
    <?php include "templets/side_nav.php"; ?>
    <div class="main">
        <div class="mobile_fram">
            <div class="mobile_display">
                <div class="land">
                    <span class="date">
                        <?php
                        $date = date('Y-m-d');
                        echo $date;
                        ?>
                    </span>
                    <img src="pic/symbol-removebg-preview.png" id="symbol">
                </div>

                <div class="card">
                    <div class="first_line">
                        <span id="bank_name">
                            NNP Bank
                        </span>

                        <span>
                            <img src="pic/visa.png" id="visa">
                        </span>
                    </div>

                    <!-- find total amount -->

                    <?php
                    $amount_find = "SELECT * FROM `money_bank` WHERE `account_id` = '$id';";
                    $result_amount = mysqli_query($conn, $amount_find);
                    $row_amount = mysqli_num_rows($result_amount);

                    if ($row_amount > 0) {
                        while ($row = mysqli_fetch_assoc($result_amount)) {
                            $total_amount = $row['amount'];
                        }
                    }
                    ?>

                    <div class="amount_details">
                        &#8377;
                        <span id="total_amount">
                            <?php
                            echo $total_amount . ".00";
                            ?>
                        </span>
                    </div>

                    <div class="last_line">
                        <span id="user_name">
                            <?php echo "Username : " . $_SESSION['username']; ?>
                        </span>

                        <span>
                            <img src="pic/chip.png" id="chip" alt="">
                        </span>
                    </div>
                </div>

                <div class="header">
                    Resent Transaction
                </div>

                <div class="history">
                    <?php
                    $count = 0;
                    $sign = "";
                    $color = "";
                    $history_sql = "SELECT * FROM `history` WHERE `account_id` = '$id' ORDER BY time DESC;";
                    $result_history = mysqli_query($conn, $history_sql);
                    $row_history = mysqli_num_rows($result_history);

                    if ($row_history > 0) {
                        while ($row = mysqli_fetch_assoc($result_history)) {
                            if ($row['paymant_status'] == 'Credited') {
                                $sign = "+";
                                $color = "green";
                            } else {
                                $sign = "-";
                                $color = "red";
                            }
                            if ($count >= 6) {
                                break;
                            }
                            echo '
                                    <div class="history_line">
                                    <img src="pic/success.png" id="suc">
            
                                    <span id="payment_status">' . $row['paymant_status'] . '</span>
            
                                    <span id="amount" style = "color: ' . $color . ';">' . $sign . ' &#8377;' . $row['amount'] . '</span>
                                    </div>                            
                                ';
                            $count += 1;
                        }
                    }
                    ?>
                </div>

                <div class="back">

                </div>
            </div>
        </div>

        <div class="order_page">
            <?php
            if ($_SESSION['login'] == true) {

                #to store account_number
                $store_account_number = "SELECT * FROM `account_details` WHERE `account_id` = '$id';";
                $result_account_number = mysqli_query($conn, $store_account_number);
                $account_number_row = mysqli_num_rows($result_account_number);

                if ($account_number_row == 1) {
                    while ($row = mysqli_fetch_assoc($result_account_number)) {
                        $account_number = $row['account_number'];
                    }
                }

                #to store account_holder_name 
                $store_account_holder = "SELECT * FROM `persnol` WHERE `account_id` = '$id';";
                $result_account_holder = mysqli_query($conn, $store_account_holder);
                $account_holder_row = mysqli_num_rows($result_account_holder);

                if ($account_holder_row == 1) {
                    while ($row = mysqli_fetch_assoc($result_account_holder)) {
                        $account_holder = $row['name'];
                    }
                }
            }
            ?>

            <div class="card2">

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
                        <p>valid</p>
                        <p>12/25</p>
                    </span>

                    <img src="pic/logo.png" class="logo">
                </div>

            </div>

            <?php
                $amount_find = "SELECT * FROM `money_bank` WHERE `account_id` = '$id';";
                $result_amount = mysqli_query($conn, $amount_find);
                $row_amount = mysqli_num_rows($result_amount);

                if ($row_amount > 0) {
                    while ($row = mysqli_fetch_assoc($result_amount)) {
                        if($row['debit_card'] == 1){
                            echo '<p class="alredy">You already Order Debit card </p>';
                            echo '<img src="pic/success.png" id="order_success">';
                        }
                        else{
                            echo '
                                <div class="sen">
                                Let\'s order your VISA NNP Bank Debit card!!
                                </div>
                                <div class="sen">
                                    Price : <del id="cut_number">&#8377; 499 </del>&#8377; 399 /- Only
                                </div>
                    
                                <form action="index.php" method="post">
                                    <button type="submit" name="order_done" id="order_button">Let\'s Order Now</button>
                                </form>                            
                            ';
                        }
                    }
                }
            ?>
        </div>
        

        <!-- details -->

        <?php
        $sql = "SELECT * FROM `persnol` WHERE `account_id` = '$id';";
        $sql_result = mysqli_query($conn, $sql);
        $sql_row = mysqli_num_rows($sql_result);

        if ($sql_row > 0) {
            while ($row = mysqli_fetch_assoc($sql_result)) {
                $holder_name = $row['name'];
                $holder_email = $row['email'];
            }
        }
        ?>

        <div class="not">
            <span class="detail">
                <span class="text_name">Holder Name : </span>
                <span class="holder_name"><?php echo ucwords($holder_name); ?></span>
            </span>
            <span class="detail">
                <span class="text_email">Holder Email : </span>
                <span class="holder_email"><?php echo $holder_email; ?></span>
            </span>
        </div>

    </div>
</body>

</html>