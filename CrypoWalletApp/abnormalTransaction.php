<?php
    include_once "connect.php";
    include_once "navbar.php";
    if (!(isset($_GET["Caller"]) && $_GET["Caller"] == "Analyst")) {
        echo "Access denied";
        header ("location: loginpage.php");
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Analyst Panel</title>
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
    <div class="container-fluid">
        <section class="it-panel-section">
            <div class="abnormal-text" style="margin-bottom: 2em">
            <h1 class="big-heading">Abnormal Transactions</h1>
                <h3 class="section-heading">Transaction Analyst Panel</h3>
                <?php
                        echo '
                        <a href="TransactionsTable.php?Caller=Analyst?Caller=Analyst" class="btn btn-create btn-table">
                            All Transactions
                        </a>
                        '
                    ?>
            </div>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#TransactionID</th>
                            <th scope="col">Suspicion Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT TransactionID, SuspicionDescription FROM abnormaltransaction";
                            $stmt = mysqli_stmt_init($con); // creation of prepared statement
                            if(!mysqli_stmt_prepare($stmt, $sql)){ // preparing it
                                echo "SQL statement failure";
                            } else {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                            }
                            while($row=mysqli_fetch_assoc($result)){ //while row is not empty (this returns an array for the next row)
                                $transactionId = htmlspecialchars($row['TransactionID']); // sanitisation used to prevent malicious characters in echo
                                $description = htmlspecialchars($row['SuspicionDescription']);
                                echo '
                                <tr>
                                    <th scope="row">'.$transactionId.'</th>
                                    <td>'.$description.'</td>
                                    <td>
                                            <a href="revokeAccount.php?Caller=Analyst" class="btn btn-delete btn-table">Verify Suspicion</a>
                                    </td>
                                </tr>';
                            }
                        ?>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <?php
                            echo '
                            <a href="revokeAccount.php?Caller=Analyst" class="btn btn-delete btn-table">
                                Revoke an Account
                            </a>
                            '
                ?>
        </section>
    </div>
</body>
