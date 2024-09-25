<?php
    session_start();

    if(!isset($_SESSION['email'])){
        header('Location: login.php');
        exit();
    }
    
    include("database.php");

    $user_id = $_SESSION['id'];
    $user_name = $_SESSION['name'];
    $user_email = $_SESSION['email'];
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BELOG | Home</title>

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
                <a href="home.php" class="home">HOME</a>
                <div class="btn__container">
                    <a href="logout.php"><button class="btn" id="logout-btn">LOG OUT</button></a>
                </div>
            </div>
        </div>
    </nav>

    <section class="container info__container" 
            style="
                flex: 0;
                padding: 2rem;
                margin-top: 2rem;
                margin-bottom: 3rem;
                border: 1px solid #000;
                background: white;
    ">
        <h3>Your Informasih</h3>
        <p><strong>Name: </strong> <?php echo htmlspecialchars($user_name); ?></p>
        <p><strong>Email: </strong> <?php echo htmlspecialchars($user_email); ?></p>

        <a href="create-post.php"><button id="post-btn">ADD POST</button></a>
    </section>

    <section class="container blogs">
        <?php
            $sql = "SELECT * FROM posts";
            $result = mysqli_query($conn, $sql);
        ?>
        <div class="blogs__container" style="margin-bottom: 4rem;">         
        <?php
            while($data = mysqli_fetch_array($result)){
                $post_owner_id = $data['user_id'];
        ?>
            <article class="blog">
                <img src="img/durian-cut.png">
                <div class="blog__container">
                    <h5><?php echo $data["title"];?></h5>
                    <p><?php echo $data["content"];?></p>
                    <label><?php echo date("j M Y @ g:i A", strtotime($data["updated_at"]));?><br></label>

                    <a href="view.php?id=<?php echo $data["id"]?>">View</a>
        
                    <?php if ($user_id == $post_owner_id): ?>
                        <a href="edit.php?id=<?php echo $data["id"]?>">Edit</a>
                        <a href="delete.php?id=<?php echo $data["id"]?>">Delete</a>
                    <?php endif; ?>
                </div>
            </article>
        <?php
            }
        ?>
        </div>
    </section>

    <script src="./main.js"></script>
</body>
</html>

<?php
    mysqli_close($conn);
?>