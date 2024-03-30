<?php
/*
$is_invalid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    //$mysqli = require __DIR__ . "/database.php";
    $connection = mysqli_connect(
        $host,
        $dbname,
        $username,
        $password
    );
    //connects to db
    //$sql = sprintf("SELECT * FROM Account
    //                WHERE Username = '%s'",
    //               $mysqli->real_escape_string($_POST["Username"]));
    $username = $_POST["Username"];
    $password = $_POST["Password"];
    $sqlQuery = "SELECT * FROM `Account` WHERE Username='$username' AND Password='$password';"
    $result = mysqli_fetch_array($mysqli->query($sql));
    //$result = mysqli_query($connection, $sqlQuery);
    //$user = $result->fetch_assoc();

    if ($result != array()) {//run if credentials are correct
        
        if (password_verify($result[2], $user["password_hash"]))//check to see if passwords match
         {
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["AccountID"];
            //starts session and holds accountid array value
            header("Location: silver.php");//ADD IN MAIN PAGE HERE!!!!!!!!! ;)
            exit;
           
        }
    }
    $is_invalid = true;


}
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z3R0</title>
    <link rel="stylesheet" href="Loginstyle.css"><!--NEED TO CHANGE!!!-->
</head>

<body>
    <div class="video-container">
        <video class="back-video" id="bg-video" autoplay loop muted plays-inline>
          <source id="video-source" src="code.mp4" type="video/mp4">
        </video>
      </div>
<!--plays the initial background video when website opens-->
    <header>
        <h2 class="logo"><li><a href="#" onmouseover="changeVideo('code.mp4')">Z3R0</a></li></h2>
          <!--makes zero logo play code video, would link to a hompage but no need in prototype-->
        <nav class="navigation">
            <ul>
            <li data-bg="snow.webp"><a href="#" onmouseover="changeVideo('about.mp4')">About</a></li>
            <li data-bg="desert.jpeg"><a href="#" onmouseover="changeVideo('services.mp4')">Services</a></li>
            <li data-bg="background.png"><a href="#" onmouseover="changeVideo('Contact.mp4')">Contact</a></li>
            <!--links to js file for changing background, would link to corresponding pages but not needed in prototype---->
            <button class="btnLogin-popup">Login</button>
            <!--button for popup, js in script at bottom-->
            </ul>
        </nav>
        <script>
            const body = document.querySelector("body");
            const li = document.querySelectorAll("li");
    
            li.forEach(el => {
                el.addEventListener("mouseover", () => {
                    let bg = el.getAttribute("data-bg");
                    body.style.background = `url(${bg})no-repeat center /cover`;
                });
            });
        </script>
        <!--above script not rly needed but it puts a picture background just in case the video background change fails, easier to see if it bugs-->
    </header>

    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close"></ion-icon>
        </span>
<!--closes login/register popup and js for it is at botom in script tag-->
<?php //if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php //endif; ?>
    <div class="form-box login">
            <h2>Login</h2>
            <form method="POST" action="Login.php">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person-circle-outline"></ion-icon>
                    </span>
                    <input type="text" name="Username" >
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="Password" >
                    <label>Password</label>
                </div>

                <button type="submit" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div>
<!--login form above-->
        <div class="form-box register">
            <h2>Registration</h2>
            <form action="process-signup.php" method="POST"><!--NEED TO CHANGE!!!-->
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" name="Email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person-circle-outline"></ion-icon>
                    </span>
                    <input type="text" name="Username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="Password" required>
                    <label >Password</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password_confirmation" required>
                    <label>Confirm Password</label>
                </div>
                <button type="submit" value="Register" name = "submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>
    <!--register form above-->

    <script>
    const wrapper = document.querySelector('.wrapper');
    const loginLink = document.querySelector('.login-link');
    const registerLink = document.querySelector('.register-link');
    const btnPopup = document.querySelector('.btnLogin-popup');
    const iconClose = document.querySelector('.icon-close');
    
    registerLink.addEventListener('click', ()=> {
        wrapper.classList.add('active');
    });
    
    loginLink.addEventListener('click', ()=> {
        wrapper.classList.remove('active');
    });
    
    btnPopup.addEventListener('click', ()=> {
        wrapper.classList.add('active-popup');
    });
    
    iconClose.addEventListener('click', ()=> {
        wrapper.classList.remove('active-popup');
        wrapper.classList.remove('active');
    });</script>
    <!--script above is for the popup from login button, it uses various transformations defined in the css to hide (shrink to 0) and transllate the forms right to left, overflow is hidden so non active form is not interactable-->
<!--NEED TO CHANGE!!!--><script src="script.js"></script><!--link to video swap script--><!--NEED TO CHANGE!!!-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!--got cool and editable icons from here (they are treated like letters)-->
</body>

</html>
