<?php

    $db_username = "sportybidwarz";
    $db_password = "sportybidwarsPES1202203108$";

    function doesItemExist($itemNo, $db) {
        return mysqli_num_rows(mysqli_query($db, "SELECT ItemNo FROM Items WHERE ItemNo = ".$itemNo)) == 1;
    }

    if( empty($_GET['id']) )
        exit("Error: Invalid Attributes.");

    $db = mysqli_connect("localhost", $db_username, $db_password, $db_username);
    
    if( !doesItemExist((int)$_GET['id'], $db) )
        exit("Error: Item does not exist.");

    $currentBidObj = mysqli_fetch_assoc(mysqli_query($db, "SELECT HighestBidderId, HighestBid, HighestBidTime FROM Items WHERE ItemNo = ".$_GET['id']));

    echo '<p id="username">'.$currentBidObj['HighestBidderId'].'</p>';
    echo '<p id="amount">'.floatval($currentBidObj['HighestBid']).'</p>';
    echo '<p id="time">'.$currentBidObj['HighestBidTime'].'</p>';
?>