<?php

$host = "127.0.0.1";
$dbname = "CryptoWallet";
$username = "root";
$password = "";

//$mysqli = new mysqli(hostname: $host,
//                     username: $username,
//                     password: $password,
//                     database: $dbname);
$connection = mysqli_connect(
    $host,
    $dbname,
    $username,
    $password
);

if ( ! filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["Password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["Password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["Password"])) {
    die("Password must contain at least one number");
}

if ($_POST["Password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}
// adds conditions to signup
$password_hash = password_hash($_POST["Password"], PASSWORD_DEFAULT);
//encrypsts passwords with hash for extra security in database
//$mysqli = require __DIR__ . "/database.php";
//connects to db

$sql = "INSERT INTO Account (Username, password_hash, Email)
        VALUES (?, ?, ?)";
    //assigns random to variables    
//$stmt = $mysqli->stmt_init();
mysqli_query($connection, $sql);
//if ( ! $stmt->prepare($sql)) {
//    die("SQL error: " . $mysqli->error);
//}

//$stmt->bind_param("sss",
//                  $_POST["Username"],
//                  $password_hash,
//                  $_POST["Email"]);
//injects details into sql
if ($stmt->execute()) {
    header("Location: signup-success.html");//CHANGE if in other folder !!!!!
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}//if email is put in twice it shows this msg