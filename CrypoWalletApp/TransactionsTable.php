<!DOCTYPE php>
<?php include_once "navbar.php"; ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Table</title>
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!--Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;900&family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Stylesheet under-->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    $connection = mysqli_connect(
        "127.0.0.1",
        "root",
        "",
        "websitedatabase"
    );
    $_SESSION["CustomerID"] = 5;
    function callDatabase($query, $fetchFunction){
    global $connection;
    $result = mysqli_query($connection, $query);
    if ($fetchFunction == "all"){
        return mysqli_fetch_all($result);
        }
    }
    ?>
    <div class="container-fluid">
        <div class="user">
        <h3 class="big-heading">Transactions</h3>
            <div class="table-responsive">
            <table class="table table-borderless align-middle">
                <thead>
                    <tr>
                        <th scope="col">#TransactionId</th>
                        <th scope="col">TransactionType</th>
                        <th scope="col">CryptoTransferred</th>
                        <th scope="col">Currency</th>
                        <th scope="col">MadeToAddress</th>
                        <?php
                        if (isset($_GET["Caller"])) {
                            if ($_GET["Caller"] == "Analyst") {
                                echo '<th scope="col">PaymentCompensated</th>';
                                echo '<th scope="col">SmartContract</th>';
                            }
                        }
                        ?>
                        <th scope="col">Timestamp</th>
                        <th scope="col">CertificateId</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!isset($_GET["Caller"])) {
                        echo "Access denied";
                    } else {
                        if($_GET["Caller"] == "User"){
                            $queryforuser = "SELECT Transaction.TransactionId, Transaction.TransactionType, Transaction.CryptoTransferred,Transaction.Currency,Transaction.MadeToAddress
                                        , Transaction.TransactionTimestamp, Transaction.CertificateID FROM Transaction, CustomerTransaction
                                        WHERE CustomerTransaction.CustomerTransactionId = Transaction.TransactionId AND CustomerTransaction.CustomerId = 5";
                            $user = callDatabase($queryforuser, "all");
                            //print_r($user);

                            foreach($user as $row){
                                echo "<tr>";
                                echo "<td>" . $row[0] . "</td>";
                                echo "<td>" . $row[1] . "</td>";
                                echo "<td>" . $row[2] . "</td>";
                                echo "<td>" . $row[3] . "</td>";
                                echo "<td>" . $row[4] . "</td>";
                                echo "<td>" . $row[5] . "</td>";
                                echo "<td>" . $row[6] . "</td>";
                                echo "</tr>";
                            }
                        }
                        elseif($_GET["Caller"] == "Analyst"){
                            echo '
                            <a href="abnormalTransaction.php?Caller=Analyst" class="btn btn-warning btn-table text-dark">
                            Suspicious Transactions
                            </a>
                            <a href="revokeAccount.php?Caller=Analyst" class="btn btn-delete btn-table">
                            Revoke an Account
                            </a>
                            ';
                            $queryforanalyst = "SELECT * FROM Transaction";
                            $analyst = callDatabase($queryforanalyst, "all");
                            foreach($analyst as $row){
                                echo "<tr>";
                                echo "<td>" . $row[0] . "</td>";
                                echo "<td>" . $row[1] . "</td>";
                                echo "<td>" . $row[2] . "</td>";
                                echo "<td>" . $row[3] . "</td>";
                                echo "<td>" . $row[4] . "</td>";
                                echo "<td>" . $row[5] . "</td>";
                                echo "<td>" . $row[6] . "</td>";
                                echo "<td>" . $row[7] . "</td>";
                                echo "<td>" . $row[8] . "</td>";
                                echo "</tr>";
                            }
                        }

                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</body>
</html>
