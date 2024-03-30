<?php
	$connection = mysqli_connect(
        "127.0.0.1",
        "root",
        "",
        "CryptoWallet"
    );
	$username = $_POST["Username"];
	$password = $_POST["Password"];

    $loginQuery = "SELECT * FROM `Account`";
    $result = mysqli_query($connection, $loginQuery);
    $rows = mysqli_fetch_all($result);
    print_r($rows);
    foreach($rows as $row){
        print_r($row);
    	if ($row[1] == $username && $row[2] == "$password"){
    		session_start();
    		$_SESSION["AccountID"] = $row[0];
    		$accountID = $_SESSION["AccountID"];
    		$_SESSION["UserID"] = $row[0];
    		$_SESSION["WalletID"] = mysqli_fetch_array(mysqli_query($connection,
    			"SELECT WalletID FROM Wallet WHERE WalletID='$accountID'")
    		)[0];
    		$walletID = $_SESSION["WalletID"];
    		$_SESSION["CustomerID"] = mysqli_fetch_array(mysqli_query($connection,
    			"SELECT CustomerID FROM Customer WHERE CustomerID='$walletID'")
    		)[0];
    		header("Location: MyWallet.php");
    	}
    }
    if ($rows == array()){
        header("Location: Loginpage.php");
    }

    //header("Location: MyWallet.php");
    
    /*
    $is_invalid = false;
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
	    $mysqli = require __DIR__ . "/database.php";
	    //connects to db
	    $sql = sprintf("SELECT * FROM Account
	                    WHERE Username = '%s'",
	                   $mysqli->real_escape_string($_POST["Username"]));
	    
	    $result = $mysqli->query($sql);
	    
	    $user = $result->fetch_assoc();
	    var_dump($user);
	    exit;
	}
	*/
?>