<?php
    session_start();
    include("database.php");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])){

        $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "signup_email", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "signup_password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($firstname)){
            echo "Nama?";
        }
        elseif(empty($lastname)){
            echo "NAMA?!";
        }
        elseif(empty($email)){
            echo "Mana email mu?!";
        }
        elseif (empty($password)){
            echo "Manoi PW mung?!";
        }
        else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname, $email, $hash);

                if (mysqli_stmt_execute($stmt)) {
                    echo "Registered successfully!";
                } else {
                    echo "SUDAH BAH REGISTERR HARI TU!!";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Database error!";
            }
        }
    }
    elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $login_email = filter_input(INPUT_POST, "login_email", FILTER_VALIDATE_EMAIL);
        $login_password = filter_input(INPUT_POST, "login_password", FILTER_SANITIZE_SPECIAL_CHARS);
    
        if (!$login_email) {
            echo "Please enter a valid email.";
        } else {
            $sql = "SELECT * FROM users WHERE email = ?";
    
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $login_email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
    
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $pass_db = $row["password"];
    
                    if (password_verify($login_password, $pass_db)) {
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['name'] = $row['first_name'].' '.$row['last_name'];
                        $_SESSION['password_hash'] = $row['password'];   
                        header("Location:home.php");
                        exit;
                    } else {
                        echo "SALAH PASS!!";
                    }
                } else {
                    echo "Email not found.";
                }
    
                mysqli_stmt_close($stmt);
            } else {
                echo "Database error!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BELOG | Login & Registration</title>

    <!-- GOOGLE FONTS (LATO & NANUM MYEONGJO & BERKSHIRE SWASH) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Nanum+Myeongjo:wght@400;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/login.css">

    <!-- BOXICONS https://boxicons.com/ -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <nav>
        <div class="container nav__container">
            <a href="index.html" class="logo">BELOG.</a>
            <div class="nav__menu">
                <a href="index.html" class="home">HOME</a>
                <div class="btn__container">
                    <button class="btn" id="login-btn" onclick="login()">LOG IN</button>
                    <button class="btn" id="signup-btn" onclick="signup()">SIGN UP</button>
                </div>
            </div>
        </div>
    </nav>



    <section class="container credential">
        <div class="login__container">
            <header>
                <div class="login__header">
                    <h2>Semalat kembali TUAN/PUAN besai kecik!</h2>
                </div>
            </header>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <div class="input__container">
                    <input type="email" name="login_email" class="input__field" placeholder="Email">
                    <i class='bx bx-envelope' ></i>
                </div>
                <div class="input__container">
                    <input type="password" name="login_password" class="input__field" placeholder="Password">
                    <i class='bx bx-lock-alt' ></i>
                </div>
                <div>
                    <input type="submit" name="login" class="submit login__submit" value="Log In">
                </div>
            </form>
    
            <p>Ku rasa ku perlu <a href="#" onclick="signup()">REGISTUR</a> bah ke bah!</p>
        </div>

        <div class="signup__container">
            <header>
                <div class="signup__header">
                    <h2>Ayuh JOIN bah ke bah!</h2>
                </div>
            </header>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <div class="name">
                    <div class="input__container">
                        <input type="text" name="firstname" class="input__field" placeholder="First Name" required>
                        <i class='bx bxs-ghost'></i>
                    </div>
                    <div class="input__container">
                        <input type="text" name="lastname" class="input__field" placeholder="Last Name" required>
                        <i class='bx bxs-ghost'></i>
                    </div>
                </div>
                <div class="input__container">
                    <input type="email" name="signup_email" class="input__field" placeholder="Email" required>
                    <i class='bx bx-envelope' ></i>
                </div>
                <div class="input__container">
                    <input type="password" name="signup_password" class="input__field" placeholder="Password" required>
                    <i class='bx bx-lock-alt' ></i>
                </div>
                <div>
                    <input type="submit" name="signup" class="submit signup__submit" value="Sign Up">
                </div>
            </form>
    
            <p>Ku punya akaun udah bos. Ku mok <a href="#" onclick="login()">LOGIN</a> luk.</p>
        </div>
    </section>



    <footer>
        <div class="container ftr__container">
            <a href="index.html" class="logo">BELOG.</a>
            
            <div class="ftr__menu">
                <p>&copy; 2024 CIPLAKDOT</p>
                <p>HOSTED BY <a href="#" target="_blank">HOST</a></p>
                <p>SITE DESIGN & DEV BY PENCIPLAK</p>
                <P><a href="mailto: contact@ciplak.com">CONTACT US</a></P>
            </div>
        </div>
    </footer>

    <script src="./main.js"></script>

</body>
</html>

<?php
    mysqli_close($conn)
?>