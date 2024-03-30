<?php   include_once "navbar.php";
        include_once "connect.php";
        if (!(isset($_GET["Caller"]) && $_GET["Caller"] == "Support")) {
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
            <h1 class="big-heading">Account Display</h1>
            <h3 class="section-heading">IT Support Panel</h3>
            <div class="table-responsive">
            <table class="table table-borderless align-middle">
                <thead>
                    <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT * FROM Account WHERE AccountID IN (SELECT StaffID FROM Staff)";
                    $stmt = mysqli_stmt_init($con);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        echo "SQL statement failure";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        while($row=mysqli_fetch_assoc($result)){ //while row is not empty (this returns an array for the next row)
                            $id = htmlspecialchars($row['AccountID'], ENT_QUOTES, 'UTF-8'); // sanitisation used to prevent malicious characters in echo
                            $username = htmlspecialchars($row['Username'], ENT_QUOTES, 'UTF-8');
                            $password = htmlspecialchars($row['Password'], ENT_QUOTES, 'UTF-8');
                            $email = htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8');
                            echo '
                            <tr>
                                <th scope="row">'.$id.'</th>
                                <td>'.$username.'</td>
                                <td>'.$password.'</td>
                                <td>'.$email.'</td>
                            </tr>';
                        } // the columns in the table are stored in variables
                        // then printed in the table
                    }
                ?>
                </tbody>
            </table>
            </div>
        </section>
    </div>
</body>
