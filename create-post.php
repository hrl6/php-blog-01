<?php
    session_start();
    
    if(!isset($_SESSION['email'])){
        header('Location: login.php');
        exit();
    }

    include("database.php");

    if(isset($_POST['create'])){
        $user_id = mysqli_real_escape_string($conn, $_SESSION['id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $visibility = mysqli_real_escape_string($conn, $_POST['visibility']);

        $sql = "INSERT INTO posts (user_id ,title, content, visibility)
        VALUES ('$user_id', '$title', '$content', '$visibility')";

        if (mysqli_query($conn, $sql)) {

        } else {
            die("Fail to create post!");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BELOG | Create POST OH!</title>

    <!-- GOOGLE FONTS (LATO & NANUM MYEONGJO & BERKSHIRE SWASH) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Nanum+Myeongjo:wght@400;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./css/style.css">

    <!-- BOXICONS https://boxicons.com/ -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <nav>
        <div class="container nav__container">
            <a href="index.html" class="logo">BELOG.</a>
            <div class="nav__menu">
                <a href="home.php" class="home">HOME</a>
                <div class="btn__container">
                <a href="logout.php"><button class="btn" id="logout-btn">LOG OUT</button></a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <form action="" method="post">
            <div class="form__field">
                <input type="text" name="title" id="title" placeholder="Title" required>
            </div>
            <div class="form__field">
                <textarea name="content" id="content" cols="50" rows="10" placeholder="Content" required></textarea>
            </div>
            <div class="form__option">
                <input type="radio" name="visibility" value="public" required>Public
                <input type="radio" name="visibility" value="private" required>Private
            </div>
            <div>
                <a href="home.php"><input type="submit" name="create" value="Create Post"></a>
            </div>
        </form>
        <a href="home.php"><button class="btn" id="back-btn">Backe</button></a>
    </div>

    <script src="./main.js"></script>
</body>
</html>