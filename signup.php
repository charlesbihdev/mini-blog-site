    <?php
    include 'header.php';
    $classes = '';
    $message = '';
    $visible = 'hide';

    if (isset($_POST['submit'])) {
        $prevLocation = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $name = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $uploadLocation = './uploads/' . basename($name);
        $allowedExtension = array("jpeg", "png");
        $allowedSize = 4000000;
        $fileExtension = explode("/", $type);


        $Firstname = $_POST['firstname'];
        $Lastname = $_POST['lastname'];
        $Email = $_POST['email'];
        $password = $_POST['password'];
        $Password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $conPassword = $_POST['conpassword'];
        $Image = $uploadLocation;

        if ($conPassword == $password) {
            if ($_SERVER['CONTENT_LENGTH'] > $allowedSize) {
                $classes = 'notification is-warning';
                $message = 'File is too large. Upload new image';
                $visible = '';
            }

            if (in_array($fileExtension[1], $allowedExtension)) {

                if ($size <= $allowedSize) {

                    move_uploaded_file($prevLocation, $uploadLocation);
                    $sql = "INSERT INTO users (firstname, lastname, email, password, image) VALUES('$Firstname', '$Lastname', '$Email', '$Password', '$Image')";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        header('location: ./login.php?account=created');
                    } else {
                        $classes = 'notification is-danger';
                        $message = 'Unable to create account. Try again';
                        $visible = '';
                    }
                } else {
                    $classes = 'notification is-warning';
                    $message = 'File is too large.  Upload new image';
                    $visible = '';
                }
            } else {
                $classes = 'notification is-warning';
                $message = 'File format is not supported.  Upload an image';
                $visible = '';
            }
        } else {
            $classes = 'notification is-warning';
            $message = 'Passwords you provided does\'nt match';
            $visible = '';
        }
    }
    ?>
    <title>UmatPress - Sign up</title>

    </head>

    <body>
        <div id="hide-it">
            <div class="<?php echo $classes ?>" id="<?php echo $visible ?>">
                <button class="delete" onclick="HideText('hide-it');"></button>
                <strong><?php echo $message ?></strong>
            </div>
        </div>

        <article class="article1">
            <div class="container1 neumor" id="expand">
                <h2 class="divItems">Sign up</h2>
                <form method="POST" action="./signup.php" enctype="multipart/form-data">
                    <div id="nameDiv">
                        <div class="divItems">
                            <label class="divItems" for="firstname">
                                <input class="firstname1" name="firstname" type="text" id="firstname" placeholder="Firstname" required>
                            </label>
                        </div>
                        <div class="divItems">
                            <label class="divItems" for="lastname">
                                <input class="firstname2" name="lastname" type="text" id="lastname" placeholder="Lastname" required>
                            </label>
                        </div>

                    </div>

                    <div class="divItems">
                        <label for="email">
                            <input type="email" id="email" name="email" placeholder="Email" class="centerh input2" required>
                        </label>
                    </div>

                    <div class="divItems">
                        <label for="password">
                            <input onfocus='ShowText("show"); Expand("expand");' ; onblur='Contract("expand"); HideText("show");' pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" type="text" id="password" name="password" placeholder="Password" class="centerh input2" required>
                            <p id="show" class="small-text"> your password must be at least 8 characters. Should <br>contain uppercase, lowercase and special character.</p>
                        </label>
                    </div>

                    <div class="divItems">
                        <label for="conpassword">
                            <input type="text" id="conpassword" name="conpassword" placeholder="Confirm Password" class="centerh input2" required>
                        </label>
                    </div>

                    <div>
                        <p id="show" class="small-text11"> Upload Profile Picture</p>

                        <input class="input2 files" type="file" name="image" placeholder="myFileInput" value="insert image" required>
                    </div>

                    <div>
                        <input class="input2 submit" type="submit" name="submit" value="Sumit">
                    </div>



                    <p>Already have an account? <a href="./login.php"> Login </a></p>



                </form>


            </div>

        </article>
        <script src="./javascript/script.js"></script>
    </body>

    </html>