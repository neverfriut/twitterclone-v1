<?php 

session_start();

http_response_code(200);
header('Content-Type: application/json');

$sUserId = $_SESSION['userId'];

if( ! isset($_SESSION['userId']) ){
    http_response_code(400);
    header('Content-Type: application/json');
    echo '{"error": "missing session ID"}';
    exit();
}


$sUsers = file_get_contents('private/users.txt');
$aUsers = json_decode($sUsers);
$aTweets = [];

foreach($aUsers as $key => $aUser){
    if($aUser->id == $sUserId){
        $aUserTweets = $aUser->tweets;
        echo json_encode($aUserTweets);
    }
};