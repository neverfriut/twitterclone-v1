
<?php 

if( ! isset($_GET['tweetId']) ){
  http_response_code(400);
  header('Content-Type: application/json');
  echo '{"error":"missing tweet ID"}';
  exit();
}

$tweetId = $_GET['tweetId'];
// echo $_GET['tweetId'];
$sUsers = file_get_contents('private/users.txt');
$aUsers = json_decode($sUsers);

//$aTweets = [];

// print_r ($aUsers[id['tweets']);

foreach($aUsers as $key => $aUser) {
  // $aUserTweets = $aUser->tweets;
  // DO NOT MAKE COPY OF ARRAY, CHANGE ORIGINAL!

  foreach($aUser->tweets as $keyTweet => $oTweet) {
    if ($oTweet->id ==  $tweetId){
      echo $oTweet->id;
      array_splice($aUser->tweets, $keyTweet, 1);
      echo "<br>";
      // print_r($aUsers);
      // echo json_encode($aUsers, JSON_PRETTY_PRINT);
      $sData = json_encode($aUsers, JSON_PRETTY_PRINT);
      file_put_contents('private/users.txt', $sData);
      break;
    }
  }
} 


header('Location: admin.php');

