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
        <section class="revoke-section">
            <div class="revoke-text" style="margin-bottom: 2em">
                <h1 class="big-heading">Revoke Account</h1>
                <h3 class="section-heading">Transaction Analyst Panel</h3>
                <?php
                            echo '
                            <a href="TransactionsTable.php?Caller=Analyst" class="btn btn-create btn-table">
                                All Transactions
                            </a>
                            '
                ?>
            </div>
            <div class="table-responsive">
            <table class="table table-borderless align-middle">
                <thead>
                    <tr>
                        <th scope="col">#accID</th>
                        <th scope="col">Suspicion</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // This selects distinct records for the account id, transaction id, username of account, password of account and email of account
                    // with usage of JOINS to connect the account class to the abnormal transaction class
                        $sql = "SELECT DISTINCT a.AccountID, at.SuspicionDescription, a.Username, a.Email
                        FROM account a
                        JOIN customer c ON a.AccountID = c.CustomerID
                        JOIN customertransaction ct ON c.CustomerID = ct.CustomerID
                        JOIN transaction t ON ct.TransactionID = t.TransactionID
                        JOIN abnormaltransaction at ON t.TransactionID = at.TransactionID;";
                        $stmt = mysqli_stmt_init($con);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            echo "SQL statement failure";
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            while($row=mysqli_fetch_assoc($result)){ //while row is not empty (this returns an array for the next row)
                                $id = htmlspecialchars($row['AccountID'], ENT_QUOTES, 'UTF-8'); // sanitisation used to prevent malicious characters in echo
                                $sus = htmlspecialchars($row['SuspicionDescription'], ENT_QUOTES, 'UTF-8');
                                $username = htmlspecialchars($row['Username'], ENT_QUOTES, 'UTF-8');
                                $email = htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8');
                                echo '
                                <tr>
                                    <th scope="row">'.$id.'</th>
                                    <td>'.$sus.'</td>
                                    <td>'.$username.'</td>
                                    <td>'.$email.'</td>
                                    <td>
                                            <a href="deleteAccount.php?deleteid='.$id.'&Caller=Analyst" class="btn btn-delete btn-table"">
                                                Delete
                                            </a>
                                    </td>
                                </tr>';
                            } // the columns in the table are stored in variables
                            // then printed in the table
                            // then the buttons for deletion will link to the deleteAccount page with the specific accountid

                        }


                    ?>
                </tbody>
            </table>
            </div>
            <?php
                            echo '
                            <a href="abnormalTransaction.php?Caller=Analyst" class="btn btn-delete btn-table">
                                Suspicious Transactions
                            </a>
                            '
                ?>
        </section>
    </div>
</body>
