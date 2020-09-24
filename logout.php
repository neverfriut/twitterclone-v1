<?php
//destroy session 
//logout is just a bridge 


session_start();
session_destroy();
header('Location: signup.php');