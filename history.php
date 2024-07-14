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
    <link rel="stylesheet" href="style/_nav.css">
    <link rel="stylesheet" href="style/history.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <?php
        include "templets/_nav.php";
   ?>

   <div class="history_table">  
        <?php
            $select_history = "SELECT * FROM `history` WHERE `account_id` = '$id' ORDER BY time DESC;";
            $selected_result = mysqli_query($conn, $select_history);
            $select_row = mysqli_num_rows($selected_result);

            if($select_row > 0){
                while($row = mysqli_fetch_assoc($selected_result)){
                    echo '
                        <div class="line">
                        <img src="pic/success.png" id="img_status">
                        <p class="payment_status">'.$row["paymant_status"].'</p>
                        <p class="desc">'.$row["desc"].'</p>
                        <p class="time">'.$row["time"].'</p>
                    ';

                    if($row["paymant_status"] == "Credited"){
                        echo '
                            <p class="amount" style="color: green;">+ &#8377;'.$row["amount"].'</p>
                        ';
                    }else{
                        echo '
                            <p class="amount" style="color: red;">- &#8377;'.$row["amount"].'</p>
                        ';
                    }
                    echo '
                        </div>
                    ';
                }
            }
        ?>
    </div>
</body>
</html>