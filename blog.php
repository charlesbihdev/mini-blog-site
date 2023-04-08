<?php
include './conn.php';
$slug = $_GET['slug'];


// Create a prepared statement
$stmt = mysqli_prepare($conn, "SELECT posts.post, posts.title, posts.image, users.firstname, users.lastname, posts.created_at FROM posts INNER JOIN users ON posts.user_id = users.id WHERE posts.slug = ?");

// Bind the $slug variable to the prepared statement as a parameter
mysqli_stmt_bind_param($stmt, "s", $slug);

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Get the results from the prepared statement
$result = mysqli_stmt_get_result($stmt);

// Fetch the blog post from the result set
$post = mysqli_fetch_assoc($result);

$fetched_post = $post['post'];
$decode_post = html_entity_decode($fetched_post);

if (mysqli_num_rows($result) < 1) {
    header('location: ./error404.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>UMaTPress - Blog</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/blog.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav>
        <div class="nav-bar">
            <a href="./login.php" style="text-decoration: none; color: black;">
                <p style="margin-left: 14px;">sign in</p>
            </a>

            <h2 style="margin-right: 14px;">UMaTPress</h2>

        </div>
    </nav>
    <!--end of Top Navigation -->

    <!-- main page -->
    <article id="main-content">
        <div id="main-page">
            <div id="thumbnail-post">
                <img id="thumbnail-img" src="<?php echo substr($post['image'], 1)  ?>" alt="thumbnail" />
            </div>
            <h1 id="title">
                <?php echo $post['title'] ?>
            </h1>
            <article id="paragraph">
                <?php echo $decode_post ?>
            </article>

        </div>
        <div class="credits">
            <p class="duthor">
                <?php echo $post['firstname'] . " " . $post['lastname'] ?>
            </p>
            <p class="date">
                <?php
                $date_time = new DateTime($post['created_at']);
                $date_only = $date_time->format('d/m/Y');
                echo $date_only;
                ?>
            </p>
        </div>

    </article>

</body>

</html>