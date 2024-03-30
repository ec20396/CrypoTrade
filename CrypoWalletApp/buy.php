<?php
    $amount = $_POST['cryptoAmount'];
    $currency = $_POST['cryptoType'];
    echo "You have successfully bought $amount $currency.";
    header("Location: subwallet.php?RequestedAsset=$currency");
    $connection = mysqli_connect(
        "127.0.0.1",
        "root",
        "",
        "CryptoWallet"
    );
    mysqli_query($connection, "INSERT INTO Transaction (TransactionType, CryptoTransferred, Currency, MadeToAddress,TransactionTimestamp, PaymentCompensated, SmartContract, CertificateID)
        VALUES ('Buy', $amount, '$currency',$timestamp, NULL, NULL, NULL, NULL);");

    $currentTransaction = mysqli_fetch_array(mysqli_query(
    	$connection, "SELECT max(TransactionID) FROM Transaction;")
	)[0];

	mysqli_query($connection, "INSERT INTO CustomerTransaction (CustomerID, TransactionID)
        VALUES ('$user_id', '$currentTransaction';")

// // Get the user's ID and subwallet ID
// $user_id = $_SESSION['UserID'];
// $customer_id = $_SESSION['CustomerID'];
// $subwallet_id = $_POST['SubwalletID'];

// // Get the subwallet's current balance
$sql = "SELECT balance FROM subwallets WHERE id = $subwallet_id";
$result = mysqli_query($db,$sql);
$subwallet = $result->fetch_assoc();
$current_balance = $subwallet['balance'];
$timestamp = date('Y-m-d H:i:s');

// // Get the amount the user wants to buy and the currency they want to buy
// $amount = $_POST['amount'];
// $currency = $_POST['currency'];

// // Get the current exchange rate for the currency
// $exchange_rate = get_exchange_rate($currency);

// // Calculate the new balance after the purchase
// $new_balance = $current_balance + ($amount / $exchange_rate);

// // Update the subwallet's balance in the database
// $sql = "UPDATE subwallets SET balance = $new_balance WHERE id = $subwallet_id";
// $db->query($sql);

// // Add a transaction to the database
// $sql = "INSERT INTO Transaction (TransactionType, CryptoTransferred, Currency, MadeToAddress,TransactionTimestamp, PaymentCompensated, SmartContract, CertificateID)
//         VALUES ('Buy', $amount, '$currency',$timestamp, NULL, NULL, NULL, NULL)";
// $db->query($sql);

// $sql = "SELECT max(TransactionID) FROM Transaction";
// $result = mysqli_query($db, $sql);
// $row = mysqli_fetch_array($result);
// $max_transaction_id = $row['max(TransactionID)'];
// $sql = "INSERT INTO CustomerTransaction (CustomerID, TransactionID)
//         VALUES ($user_id, $max_transaction_id)";
// $db->query($sql);


// $sql = "SELECT balance FROM Wallet WHERE CustomerID = $user_id";
// $result = mysqli_query($db, $sql);
// $row = mysqli_fetch_array($result);
// $wallet_balance = $row['balance'];
// $new_wallet_balance = $wallet_balance + $new_balance;
// $sql = "UPDATE Wallet SET balance = $new_wallet_balance WHERE CustomerID = $user_id";
// $db->query($sql);



// // Redirect to the subwallet page
// header("Location: subwallet.php?id=$subwallet_id");
// exit;

// function get_exchange_rate($currency) {
//     // This function would retrieve the current exchange rate for the specified currency from an external API or database
//     // and return it as a float. For simplicity, we'll just return a random number between 0.5 and 2.0.
//     return rand(50, 200) / 100;
// }
?>
