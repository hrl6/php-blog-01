<?php
    include("database.php");
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

    <section class="container">
        <div class="post__container">
            <?php
                $id = $_GET['id'];
                $sql_view_post = "SELECT * FROM posts WHERE id = $id";
                $result = mysqli_query($conn, $sql_view_post);
                
                while($data = mysqli_fetch_array($result)){
            ?>
                    <h3><?php echo $data['title']; ?></h3>
                    <p><?php echo date("j M Y", strtotime($data['updated_at'])); ?><br></p>
                    <p><?php echo $data['content']; ?></p>
            <?php        
                }
            ?>
        </div>
    </section>
</body>
</html>