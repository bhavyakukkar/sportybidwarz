<?php

    $db_username = "sportybidwarz";
    $db_password = "sportybidwarsPES1202203108$";

    function doesItemExist($itemNo, $db) {
        return mysqli_num_rows(mysqli_query($db, "SELECT ItemNo FROM Items WHERE ItemNo = ".$itemNo)) == 1;
    }

    function getItemBaseBid($itemNo, $db) {
        return floatval(mysqli_fetch_assoc(mysqli_query($db, "SELECT BaseBid FROM Items WHERE ItemNo = ".$itemNo))['BaseBid']);
    }

    function getCurrentHighestBid($itemNo, $db) {
        return floatval(mysqli_fetch_assoc(mysqli_query($db, "SELECT HighestBid FROM Items WHERE ItemNo = ".$itemNo))['HighestBid']);
    }

    function setNewHighestBid($itemNo, $id, $amount, $db) {
        $itemBaseBid = getItemBaseBid($itemNo, $db);
        $itemCurrentHighestBid = getCurrentHighestBid($itemNo, $db);

        if( $itemBaseBid >= $amount || $itemCurrentHighestBid >= $amount )
            exit("Error: New Bid is smaller than Existing Bid or smaller than Base Price.");
        
        mysqli_query($db, "UPDATE Items SET HighestBidderId = '".$id."', HighestBid = ".$amount." WHERE ItemNo = ".$itemNo);
    }

    if( empty($_GET['item']) || empty($_GET['id']) || empty($_GET['amt']) )
        exit("Error: Invalid Attributes.");
    
    $db = mysqli_connect("localhost", $db_username, $db_password, $db_username);

    if( !doesItemExist((int)$_GET['item'], $db) )
        exit("Error: Item does not exist.");
    
    setNewHighestBid(
        (int)$_GET['item'],
        $_GET['id'],
        floatval($_GET['amt']),
        $db
    );

?>