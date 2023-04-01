<?php
include '../conn.php';
session_start();
$classes = '';
$message = '';
$visible = 'hide';

if (isset($_SESSION['user_id'])) {

    $userid = $_SESSION['user_id'];
    $sql = "SELECT * FROM users where id=$userid";
    $result = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($result);

    //if user is admin render all posts
    if ($r['isadmin'] == 1) {
        $join_query = "SELECT posts.post, posts.post_id, posts.slug, posts.title, posts.image, posts.created_at, users.firstname, users.lastname
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id";
    } else
    // else render the posts of the that particular user
    {
        $join_query = "SELECT posts.post, posts.post_id, posts.slug, posts.title, posts.image, posts.created_at, users.firstname, users.lastname
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id WHERE users.id = $userid";
    }

    $join_result = mysqli_query($conn, $join_query);

    $RS = mysqli_fetch_all($join_result, MYSQLI_ASSOC);

    if (mysqli_num_rows($join_result) < 1) {
        $available = ' ';
    } else {
        $available = 'none';
    }
} else {
    header('location: ../login.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="../node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./blog.css">
    <link rel="stylesheet" href="./members.css">
    <link rel="stylesheet" href="./post.css">
    <link rel="stylesheet" href="./bulma.css">

    <style>
        #hide {
            display: none;
        }



        #hide-it {
            text-align: center;
        }

        .interface {
            display: none;
        }

        .tab.active {
            background-color: #efe9ff;
        }

        .interface.active {
            display: block;
        }

        #insertImage-1,
        #insertFiles-1,
        #moreRich-1,
        #markdown-1,
        #fr-logo,
        .fr-quick-insert {
            display: none;
        }
    </style>
</head>

<body>


    <div id="main-container">
        <?php
        include './navbar.php';
        include './sidebar.php';
        include './post.php';
        include './group-members.php';

        ?>




    </div>

    <script>
        let tabs = document.querySelectorAll(".tab");
        let interface = document.querySelectorAll(".interface");

        tabs.forEach(tab => {

            tab.addEventListener('click', event => {
                tabs.forEach(taba => {
                    taba.classList.remove('active');
                })

                tab.classList.add('active')

                interface.forEach(view => {
                    view.classList.remove('active')

                })

                const viewid = tab.getAttribute('in-type');

                document.getElementById(viewid).classList.add('active')
            })
        })
    </script>
    <script src="../javascript/script.js"></script>

</body>

</html>