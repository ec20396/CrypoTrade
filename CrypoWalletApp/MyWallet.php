<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>My Wallet</title>
        <link rel="stylesheet" href="MyWalletStylesheet.css">
        <link rel="stylesheet" href="MyWalletBootstrapPHPStylesheet.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <!--Google fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;900&family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#303030;">
                <a class="navbar-brand">Project Z<span class="num">3</span>R<span class="num">0</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                        <a class="nav-link" href="#footer">Account</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="MyWallet.php">Wallet</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="TransactionsTable.php?Caller=User">Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>


        <?php
            session_start();
            $connection = mysqli_connect(
                "127.0.0.1",
                "root",
                "",
                "CryptoWallet"
            );

            function callDatabase($query, $fetchFunction){
                global $connection;
                $result = mysqli_query($connection, $query);

                if ($fetchFunction == "all"){
                    return mysqli_fetch_all($result);
                }
                else if ($fetchFunction == "array"){
                    return mysqli_fetch_array($result);
                }
            }

            $queryForOverview = "SELECT TotalBalance, NumberOfSubwallets FROM Wallet WHERE WalletID = " . $_SESSION["WalletID"] . ";";
        ?>

        <div class="walletOverview">
            <?php
                $overviewData = callDatabase($queryForOverview, "array");

                if($overviewData != array()) {
                    $totalBalance = $overviewData[0];
                    $numberOfSubwallets = $overviewData[1];
                }
                else{
                    $totalBalance = 0;
                    $numberOfSubwallets = 0;
                }
            ?>
            <h4 id="totalBalanceHeader">
                Balance
            </h4>
            <h1 id="totalBalance">
                <?php echo $totalBalance; ?>
            </h1>
            <h4 id="totalSubwalletsNumberHeader">
                Sub wallets
            </h4>
            <h2 id="numberOfSubWallets">
                <?php echo $numberOfSubwallets; ?>
            </h2>


        </div>

        <div class="subwallets">
            <table>
                <?php
                    $queryForSubwallets = "SELECT CurrencySubwallet.CurrencyName, CurrencySubwallet.Balance FROM CurrencySubwallet, WalletSubwallet, Wallet 
                        WHERE CurrencySubwallet.SubwalletID = WalletSubwallet.SubwalletID AND 
                        WalletSubwallet.WalletID = Wallet.WalletID AND Wallet.WalletID = " . $_SESSION["WalletID"] . ";";
                    $subwallets = callDatabase($queryForSubwallets, "all");

                    if($subwallets != array()){
                        foreach($subwallets as $subwallet){
                        ?>
                        <tr>
                            <?php
                                $currencyName = $subwallet[0];
                                $subwalletBalance = $subwallet[1];
                            ?>
                            <td>
                                <a href="SubWallet.php">
                                    <?php echo $currencyName; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo $subwalletBalance; ?>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <?php
                        }
                    }
                    else{
                        echo "<h3 id='noSubwallets'>Sorry, nothing is present yet</h3>";
                    }
                    ?>
            </table>

            <button id="addSubwalletButton">
                Add New Subwallet
            </button>

            <button id="removeSubwalletButton">
                Remove Subwallet
            </button>
        </div>

        <div class="latestTransactions">
            <h1>
                Transactions
            </h1>

            <a href="TransactionsTable.php?Caller=User">
                See More
            </a>

            <table>
                <?php
                    $queryForTransactions = "SELECT Transaction.Currency, Transaction.TransactionType, Transaction.CryptoTransferred   
                        FROM `CustomerTransaction`, `Transaction` WHERE CustomerTransaction.CustomerID = " . $_SESSION["CustomerID"] . ";";
                    $last4Transactions = array_slice(callDatabase($queryForTransactions, "all"), -4);

                    if($last4Transactions != array()){
                        foreach($last4Transactions as $transaction){
                            ?>
                            <tr>
                                <?php
                                    $currency = $transaction[0];
                                    $transactionType = $transaction[1];
                                    $cryptoTransferred = $transaction[2];

                                ?>
                                <td>
                                    <?php echo $currency; ?>
                                </td>
                                <td>
                                    <?php echo $transactionType; ?>
                                </td>
                                <td>
                                    <?php echo $cryptoTransferred; ?>
                                </td>
                            </tr>
                            <?php

                        }
                    }
                    else{
                        echo "<h3 id='noTransactions'>Sorry, nothing is present yet</h3>";
                    }
                ?>
            </table>
        </div>

        <div class="modalAdd">
            <div class="addSubwalletPopup">
                <h2>
                    Add New Subwallet
                </h2>

                <form id="AddForm" method="POST" action="Subwallets.php?Action=Add">
                    <label for="assetsChoices">
                        Choose Asset
                    </label>
                    <select name="assetsChoices" id="assetsChoices">
                        <option>
                            Select
                        </option>
                    </select>
                </form>

                <button type="submit" form="AddForm" id="addConfirmButton">
                    Confirm
                </button>
                <button id="addCancelButton">
                    Cancel
                </button>
            </div>
        </div>

        <div class="modalRemove">
            <div class="removeSubwalletPopup">
                <h2>
                    Remove Subwallet
                </h2>

                <form id="RemoveForm" method="POST" action="Subwallets.php?Action=Remove">
                    <label for="currencyName">
                        Currency Name
                    </label>
                    <input type="text" name="currencyName" id="currencyName"/>
                </form>

                <button type="submit" form="RemoveForm" id="removeConfirmButton">
                    Confirm
                </button>
                <button id="removeCancelButton">
                    Cancel
                </button>
            </div>
        </div>

        <script src="WalletScript.js"></script>
    </body>
</html>