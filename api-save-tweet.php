<?php

session_start();

//ref the session[userId]
$sUserId = $_SESSION['userId']; 

// a tweet has a unique id 
$sTweetId = uniqid();

if( ! isset($_POST['tweetTitle']) ){
    http_response_code(400);
    header('Content-Type: application/json');
    echo '{"error":"missing message"}';
    exit();
}

if( strlen($_POST['tweetTitle']) < 2){
    http_response_code(400);
    header('Content-Type: application/json');
    echo '{"error":"message must be at least 2 characters"}';
    exit();
}

if(strlen($_POST['tweetTitle']) > 140 ){
    http_response_code(400);
    header('Content-Type: application/json');
    echo '{"error":"message cannot be longer than 140 characters"}';
    exit();
}

$sUsers = file_get_contents('private/users.txt');
$aUsers = json_decode($sUsers);

$postTitle = $_POST['tweetTitle'];

foreach($aUsers as $aUser){
    //iniciate a tweet belongs to specific user that is current in the session
    if($aUser->id == $sUserId) {
        $jTweet = new stdClass();
        $jTweet->id = $sTweetId;
        $jTweet->author = $_SESSION['firstname'];
        $jTweet->message = $postTitle;
        $jTweet->active = 1; 
        $aUser->tweets[] = $jTweet;

        print_r($jTweet);

        break;
    }
};

file_put_contents('private/users.txt', json_encode($aUsers));
header('Location: admin.php');