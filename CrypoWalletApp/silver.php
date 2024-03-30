<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM Account
            WHERE AccountID = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}
//brings user info from login into this page!!!!!

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>Home</h1>
    
    <?php if (isset($user)): ?>
        
        <p>Hello <?= htmlspecialchars($user["Username"]) ?></p>
        
        <p><a href="logout.php">Log out</a></p> <!--LOGOUT BUTTON!!!-->
        
    <?php else: ?>
        
        <p><a href="loginpage.php">Log in/sign up</a></p>
        
    <?php endif; ?>
    
</body>
</html>
