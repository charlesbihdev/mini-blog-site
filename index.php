<?php
include './header.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
    $sql = "SELECT * FROM users where id=$userid";
    $result = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($result);
} else {
    header('location: ./login.php');
}


?>


<title>Dashboard</title>

</head>

<body>
    <h1>Hi <?php echo $r['firstname'] ?>, welcome to dashboard</h1>
    <img src="<?php echo $r['image'] ?>" height="350px" width="350px">
    <br>

    <a href="./logout.php">
        <button style="padding: 10px; margin-top:20px; background-color: red;" name="logout">logout</button>
    </a>

</body>

</html>