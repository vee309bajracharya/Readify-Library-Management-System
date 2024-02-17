<?php

//hostName, User , Password, DatabaseName
$conn = mysqli_connect("localhost", "root", "", "readify_lms") or die("Couldn't connect");



//==== Database Creation ===========
// $sql = "CREATE DATABASE IF NOT EXISTS readify_lms";
// if($conn->query($sql) === TRUE){
//     echo "DATABASE CREATED";
// }else{
//     echo "Error : ",$conn->error;
// }

//======== Table Creation ==========
$sql = "CREATE TABLE IF NOT EXISTS library_users(
    user_id int PRIMARY KEY  NOT NULL AUTO_INCREMENT,
    fullname varchar(255),
    username varchar(255),
    email varchar(255),
    phone_number varchar(10),
    pwd varchar(255),
    address varchar(255),
    library_card_number varchar(20)
)";

// if ($conn->query($sql) === TRUE) {
//     echo "Table created";
// } else {
//     echo "Error";
// }

?>