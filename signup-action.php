<?php

if (!$_POST){
    header('Location: signup.php');
};

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: signup.php');
    exit();
};

$sUsers = file_get_contents('private/users.txt');
$aUsers = json_decode($sUsers);

// Check for dublicated emails 

foreach ($aUsers as $aUser) {
    if ($aUser->email == $_POST['email']){
        header('Location: signup.php');
        exit();
    };
};
//Password cannot be plain text - must be hashed
$userPasswordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

// think of this as an alternative to associative arrays 
// the new stdClass will create an object inside {}
// the -> creates the value 
$jUser = new stdClass (); 
$jUser->id = uniqid();
$jUser->firstname = $_POST['firstname'];
$jUser->lastname = $_POST['lastname'];
$jUser->email = $_POST['email'];
$jUser->password = $userPasswordHash;
$jUser->tweets = [];

$sTweets = json_encode($aTweets);


//pushes the data from the $jUser to the array of $aUsers 
array_push($aUsers, $jUser);

//writes the data from the $aUsers to the txt file and encodes the $aUsers into text
file_put_contents('private/users.txt', json_encode($aUsers));
header('Location: login.php');
exit();