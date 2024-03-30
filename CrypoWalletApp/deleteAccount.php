<?php
    include 'connect.php';
    include 'navbar.php';

    if (!(isset($_GET["Caller"]) && $_GET["Caller"] == "Analyst")) {
        echo "Access denied";
        header ("location: index.php");
    }
    if (isset($_GET['deleteid'])){
        $id=$_GET['deleteid']; // this will access the id from the url

        mysqli_begin_transaction($con); // This ensures that if one of the queries fails all will fail as well to avoid uncaught deletions
        // this is known as an all or nothing transaction

        try {
            $sql_user = "DELETE FROM user WHERE UserID = ?";
            $stmt_user = mysqli_stmt_init($con);
           if (mysqli_stmt_prepare($stmt_user, $sql_user)) { // Initialize and prepare the statement
                mysqli_stmt_bind_param($stmt_user, "i", $id); // i means integer here binds id to ?
                mysqli_stmt_execute($stmt_user); // executes the statement
                mysqli_commit($con);
                header('location: revokeAccount.php?Caller=Analyst');
            }
        } catch (Exception $e){
            mysqli_rollback($con); // if exception is thrown nothing is deleted
            echo "Deletion of account failure";
        }
    }



?>
