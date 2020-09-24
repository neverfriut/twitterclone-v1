<?php

if( ! isset($_POST['newTweetTitle']) ){
    http_response_code(400);
    header('Content-Type: application/json');
    echo '{"error":"Missing Message"}';
    exit();
}

if( strlen($_POST['newTweetTitle']) < 2){
    http_response_code(400);
    header('Content-Type: application/json');
    echo '{"error":"Message has to be at least 2 characters"}';
    exit();
}

if( strlen($_POST['newTweetTitle']) > 140 ){
    http_response_code(400);
    header('Content-Type: application/json');
    echo '{"error":"Message cannot be longer than 140 characters"}';
    exit();
}

$tweetId = $_GET['tweetId'];

$sUsers = file_get_contents('private/users.txt');
$aUsers = json_decode($sUsers);

foreach($aUsers as $key => $aUser){

    foreach($aUser->tweets as $KeyTweet => $oTweet) {
        if( $oTweet->id == $tweetId){
            echo ($oTweet->message);
            $oTweet->message = $_POST['newTweetTitle'];
            echo "<br>";
            echo ($_POST['newTweetTitle']);

            $sData = json_encode($aUsers, JSON_PRETTY_PRINT);
            file_put_contents('private/users.txt', $sData);
            break;
        }
    }
}

header('Location: admin.php');