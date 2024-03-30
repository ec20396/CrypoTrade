<?php
    $connection = mysqli_connect(
        "127.0.0.1",
        "root",
        "",
        "CryptoWallet"
    );

    function getLastID($entity){
        global $connection;
        $entityPrimaryKey = getIndex($entity);
        return mysqli_fetch_array(
            mysqli_query($connection, "SELECT Max(`$entityPrimaryKey`) FROM `$entity`")
        )[0];
    }

    function getIndex($entity){
        global $connection;
        return mysqli_fetch_array(
            mysqli_query($connection, "DESCRIBE `$entity`")
        )[0];
    }

    function callDatabase($query){
        global $connection;
        return mysqli_query($connection, $query);
    }

    if ($_GET["Action"] == "Add") {
        $_SESSION["WalletID"] = "1";
        $walletID = $_SESSION["WalletID"];

        $currenciesShorthandToDisplay = array("btc" => "Bitcoin", "eth" => "Ethereum", "ltc" => "Litecoin", "bch" => "Bitcoin Cash", "bnb" => "Binance Coin",
            "eos" => "EOSIO", "xrp" => "XRP Ledger", "xlm" => "Stellar Lumens", "link" => "Chainlink", "dot" => "Polkadot", "yfi" => "Yearn.finance");

        $currenciesShorthandToURL = array("btc" => "bitcoin", "eth" => "ethereum", "ltc" => "litecoin", "bch" => "bitcoincash", "bnb" => "binancecoin",
            "eos" => "eos", "xrp" => "ripple", "xlm" => "stellar", "link" => "chainlink", "dot" => "polkadot", "yfi" => "yearn-finance");

        $assetsChoice = $_POST["assetsChoices"];
        $currentSubwalletID = getLastID("CurrencySubwallet") + 1;

        callDatabase("INSERT INTO `CurrencySubwallet` (CurrencyName, Balance) VALUES ('$assetsChoice', 0);");
        callDatabase("INSERT INTO `WalletSubwallet` (WalletID, SubwalletID) VALUES ('$walletID', (SELECT MAX(SubwalletID) FROM `CurrencySubwallet`));");
        $numberOfSubwallets = mysqli_fetch_array(callDatabase(
            "SELECT COUNT(SubwalletID) FROM WalletSubwallet WHERE WalletID = 1;")
        )[0];
        callDatabase("UPDATE `Wallet` SET NumberOfSubwallets='$numberOfSubwallets' WHERE WalletID = 1;");
        header("Location: MyWallet.php");
    }

    elseif($_GET["Action"] == "Remove"){
        $currencyName = $_POST["currencyName"];
        $IDForSubwallet = mysqli_fetch_array(callDatabase(
            "SELECT SubwalletID FROM `CurrencySubwallet` WHERE CurrencyName='$currencyName';")
        );

        callDatabase("DELETE FROM `WalletSubwallet` WHERE SubwalletID = '$IDForSubwallet[0]';");
        callDatabase("DELETE FROM `CurrencySubwallet` WHERE SubwalletID = '$IDForSubwallet[0]';");
        $numberOfSubwallets = mysqli_fetch_array(callDatabase(
            "SELECT COUNT(SubwalletID) FROM WalletSubwallet WHERE WalletID = 1;")
        )[0];
        callDatabase("UPDATE `Wallet` SET NumberOfSubwallets='$numberOfSubwallets' WHERE WalletID = 1;");
        header("Location: MyWallet.php");
    }
?>