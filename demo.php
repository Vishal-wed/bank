<?php
    session_start();
    include "templets/_dbconnect.php";
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
    <link rel="stylesheet" href="style/demo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .card{
            background-image: url(pic/bg6.jpg);
            background-size: cover;
        }
    </style>
</head>
<body>

    <?php
        if($_SESSION['login'] == true){
            
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
        }
    ?>

    <div class="card">
        
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

    <a href="index.php">
        <button id="back">Back</button>
    </a>

</body>
</html>