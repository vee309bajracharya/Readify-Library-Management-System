<?php

session_start(); //start session
session_destroy(); //destory session, as users value won't be there anymore and user won't be able to access dashboard page again

header("Location: ./log-in.php");


?>
