<?php
    include 'header.php';
    $message = '';
    $classes = '';
    $message = '';
    $visible = 'hide';

    if(isset($_GET['account']) && $_GET['account'] == 'created'){
        $classes = 'notification is-success';
        $message = 'Account created successfully. Enter your details to login';
        $visible = '';

    }

    if(isset($_POST['submit'])){
        $email =  $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM USERS WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0){
            $r = mysqli_fetch_assoc($result);
            if(password_verify($password, $r['password'])){
                session_start();
                $_SESSION['user_id'] = $r['id'];
                header('location: ./index.php');
            }

            else {
                $classes = 'notification is-danger';
                $message = 'Wrong login details. Please Enter the correct details';
                $visible = '';
            }
            
        }
        
        
        
        else{
            $classes = 'notification is-danger';
            $message = 'Wrong login details. Please Enter the correct details';
            $visible = '';
        }
    }
?>
    <title>UmatPress - Login</title>
</head>
<body>
<div id="hide-it">
<div class="<?php echo $classes ?>" id="<?php echo $visible ?>">
  <button class="delete" onclick="HideText('hide-it');"></button>
   <strong><?php echo $message ?></strong>
</div>
</div>
    <article class="article1">
        <div class="container2 neumor">
            <h2 class="divItems">Sign in</h2>
            <form method="post" action="./login.php">
                <div class="divItems">
                    <label class="divItems" for="email">
                        <p class="inputTitle">Email</p>
                        <input class="input1" name="email" type="email" id="email"placeholder="Enter your Email" required>
                    </label>
                </div>
                
                <div class="divItems">
                    <label for="password">
                        <p class="inputTitle"> Password</p>  
                        <input class="input1" name="password" type="text" id="password" placeholder="Enter your Password" class="centerh" required>
                    </label>
                </div>

                <div>
                    <input class="input1 submit" name="submit" type="submit" value="Sumit" >

                </div>
                <p>Dont have an account? <a href="./signup.php"> sign up </a></p>
                
                

            </form>

        </div>

    </article>

    <!-- 07/03/2023 midnight-->
    <script src="./javascript/script.js"></script>
</body>
</html>