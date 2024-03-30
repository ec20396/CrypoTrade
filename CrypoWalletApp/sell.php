<?php
   $amount = $_POST['cryptoAmount'];
   $currency = $_POST['cryptoType'];
   echo "You have successfully sold $amount $currency.";
   header("Location: subwallet.php?RequestedAsset=$currency");
// // Get the current user's ID and the amount and currency they want to sell
// $user_id = $_SESSION['user_id'];
// $amount = $_POST['amount'];
// $currency = $_POST['currency'];

// // Get the current balance of the user's subwallet for the currency they want to sell
// $stmt = $pdo->prepare("SELECT balance FROM subwallets WHERE user_id = ? AND currency = ?");
// $stmt->execute([$user_id, $currency]);
// $balance = $stmt->fetchColumn();
// $timestamp = date('Y-m-d H:i:s');

// // Check if the user has enough balance to sell
// if ($balance < $amount) {
//     die("Error: You don't have enough balance to sell that amount of $currency.");
// }

// // Calculate the new balance after selling
// $new_balance = $balance - $amount;

// // Update the subwallet balance in the database
// $stmt = $pdo->prepare("UPDATE subwallets SET balance = ? WHERE user_id = ? AND currency = ?");
// $stmt->execute([$new_balance, $user_id, $currency]);

// $sql = "INSERT INTO Transaction (TransactionType, CryptoTransferred, Currency, MadeToAddress,TransactionTimestamp, PaymentCompensated, SmartContract, CertificateID)
//         VALUES ('Sell', $amount, '$currency',$timestamp, NULL, NULL, NULL, NULL)";
// $db->query($sql);

// $sql = "SELECT max(TransactionID) FROM Transaction";
// $result = mysqli_query($db, $sql);
// $row = mysqli_fetch_array($result);
// $max_transaction_id = $row['max(TransactionID)'];
// $sql = "INSERT INTO CustomerTransaction (CustomerID, TransactionID)
// VALUES ($user_id, $max_transaction_id)";
// $db->query($sql);

// $sql = "SELECT balance FROM Wallet WHERE CustomerID = $user_id";
// $result = mysqli_query($db, $sql);
// $row = mysqli_fetch_array($result);
// $wallet_balance = $row['balance'];
// $new_wallet_balance = $wallet_balance - $amount;
// $sql = "UPDATE Wallet SET balance = $new_wallet_balance WHERE CustomerID = $user_id";
// $db->query($sql);

// echo "You have successfully sold $amount $currency.";
?>