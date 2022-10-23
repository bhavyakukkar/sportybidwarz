<?php

    function getCurrentHighestBid($itemNo) {
        $res = mysqli_query(
            mysqli_connect("localhost", "sportybidwarz", "sportybidwarsPES1202203108$", "sportybidwarz"),
            "SELECT * FROM Items WHERE ItemNo = ".$itemNo
        );

        if(mysqli_num_rows($res) == 1)
            return floatval(mysqli_fetch_assoc($res)['HighestBid']);
        else
            exit("Error: Item does not exist.");
    }

    function setNewHighestBid($itemNo, $id, $amount) {
        if(getCurrentHighestBid() < $amount) {
            mysqli_query(
                mysqli_connect("localhost", "sportybidwarz", "sportybidwarsPES1202203108$", "sportybidwarz"),
                "UPDATE Items SET HighestBidderNo = ".$id.", HighestBid = ".$amount." WHERE ItemNo = ".$itemNo
            );
        }
        else
            exit("Error: New Bid is smaller than Existing Bid.");
    }

    if( !empty($_GET['item']) && !empty($_GET['id'] && !empty($_GET['amt']) ) ) {
        setNewHighestBid(
            (int)$_GET['item'],
            (int)$_GET['id'],
            floatval($_GET['amt'])
        );
    }
    else {
        exit("Error: Invalid Attributes.");
    }

?>