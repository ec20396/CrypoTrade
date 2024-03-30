<?php
    $amount = $_POST['cryptoAmount'];
    $currency = $_POST['cryptoType'];
    $currency2 = $_POST['cryptoType2'];
    echo "You have successfully exchanged $amount of $currency into cryptoType2.";
    header("Location: subwallet.php?RequestedAsset=$currency");
// // get form data
// $from_currency = $_POST['from_currency'];
// $to_currency = $_POST['to_currency'];
// $amount = $_POST['amount'];
// $timestamp = date('Y-m-d H:i:s');
// // check if user has enough balance for the exchange
// $from_subwallet_balance_query = "SELECT balance FROM subwallets WHERE user_id = $user_id AND currency = '$from_currency'";
// $from_subwallet_balance_result = mysqli_query($conn, $from_subwallet_balance_query);
// $from_subwallet_balance = mysqli_fetch_assoc($from_subwallet_balance_result)['balance'];

// if ($from_subwallet_balance < $amount) {
//   echo "You don't have enough $from_currency to make the exchange.";
//   exit();
// }

// // get exchange rate from CoinGecko API
// $exchange_rate_url = "https://api.coingecko.com/api/v3/simple/price?ids=$from_currency&vs_currencies=$to_currency";
// $exchange_rate_json = file_get_contents($exchange_rate_url);
// $exchange_rate_data = json_decode($exchange_rate_json, true);
// $exchange_rate = $exchange_rate_data[$from_currency][$to_currency];

// $new_from_subwallet_balance = $from_subwallet_balance - $amount;
// $new_to_subwallet_balance = ($amount * $exchange_rate);

// $update_from_subwallet_query = "UPDATE subwallets SET balance = $new_from_subwallet_balance WHERE user_id = $user_id AND currency = '$from_currency'";
// $update_to_subwallet_query = "UPDATE subwallets SET balance = balance + $new_to_subwallet_balance WHERE user_id = $user_id AND currency = '$to_currency'";
// mysqli_query($conn, $update_from_subwallet_query);
// mysqli_query($conn, $update_to_subwallet_query);


// $transaction_query = "INSERT INTO Transaction (TransactionType, CryptoTransferred, Currency, MadeToAddress,TransactionTimestamp, PaymentCompensated, SmartContract, CertificateID)
//                       VALUES ('Buy', $amount, '$currency',$timestamp, NULL, NULL, NULL, NULL)";
// mysqli_query($conn, $transaction_query);

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

?>