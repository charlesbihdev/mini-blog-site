<?php
include '../conn.php';
session_start();
$classes = '';
$message = '';
$visible = 'hide';
function generateSlug($text)
{
  // Replace spaces and special characters with hyphens
  $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', $text);

  // Remove leading and trailing hyphens
  $slug = trim($slug, '-');

  // Convert to lowercase
  $slug = strtolower($slug);

  return $slug;
}



if (isset($_SESSION['user_id'])) {

  if (isset($_GET['post_id'])) {
    $to_be_edited = $_GET['post_id'];
    $query_get = "SELECT * FROM posts WHERE post_id=$to_be_edited";
    $res = mysqli_query($conn, $query_get);
    $edit = mysqli_fetch_assoc($res);

    $fetched_post = $edit['post'];
    $decode_post = html_entity_decode($fetched_post);
    $initial_value = $decode_post;
  } else {
    $initial_value = '';
  }


  $userid = $_SESSION['user_id'];
  $sql = "SELECT * FROM users where id=$userid";
  $result = mysqli_query($conn, $sql);
  $r = mysqli_fetch_assoc($result);

  if (isset($_POST['submitit'])) {
    $prevLocation = $_FILES['image']['tmp_name'];
    $size = $_FILES['image']['size'];
    $name = $_FILES['image']['name'];
    $type = $_FILES['image']['type'];
    $uploadLocation = '../blog_images/' . basename($name);
    $allowedExtension = array("jpeg", "png");
    $allowedSize = 4000000;
    $fileExtension = explode("/", $type);


    $user_id = $_SESSION['user_id'];
    $titles = htmlspecialchars($_POST['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $blog_slug = htmlspecialchars(generateSlug($titles), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $content = htmlspecialchars($_POST['blogtext'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

    if (in_array($fileExtension[1], $allowedExtension)) {

      if ($size <= $allowedSize) {

        move_uploaded_file($prevLocation, $uploadLocation);

        if (isset($_GET['post_id'])) {
          $insert_post = "UPDATE posts SET user_id = '$user_id', post = '$content', slug = '$blog_slug', title = '$titles', image = '$uploadLocation' WHERE post_id = '$to_be_edited'";
        } else {
          $insert_post = "INSERT INTO posts (user_id, post, slug, title, image) VALUES ('$user_id', '$content', '$blog_slug', '$titles', '$uploadLocation')";
        }

        $insert_result = mysqli_query($conn, $insert_post);

        if ($insert_result) {
          $classes = 'notification is-success';
          $message = 'Article created successfully';
          $visible = '';
          header('location: ./dashboard.php');
        } else {
          $classes = 'notification is-danger';
          $message = 'Couldnt create Article';
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
  }
} else {
  header('location: ../login.php');
}

// Define a variable with the initial value for the editor





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
      display: none !important;
    }

    .cont:hover {
      transform: scale(1.02);
    }

    #hide-it {
      text-align: center;
    }

    #insertImage-1,
    #insertFiles-1,
    #moreRich-1,
    #markdown-1,
    #fr-logo,
    .fr-quick-insert {
      display: none;
    }

    .tab.active {
      background-color: #efe9ff;
    }
  </style>
</head>

<body>


  <div id="main-container">
    <?php

    if ($r['isadmin'] == 1) {
      $isadmin = 'ADMIN';
    } else
    // else render the posts of the that particular user
    {
      $isadmin = 'USER';
    }
    include './navbar.php';
    include './sidebar1.php';
    ?>

    <form class="interface active" id="tab2" action="" method="POST" enctype="multipart/form-data">
      <article class=" item create-post-flex g-padding">
        <div id="hide-it">
          <div class="<?php echo $classes ?>" id="<?php echo $visible ?>">

            <i class="delete fa-solid fa-xmark" onclick="HideText('hide-it')"></i>
            <strong><?php echo $message ?></strong>
          </div>
        </div>
        <div class="write write1">
          <a href="./create-post.php">
            <button type="button" id="discard" class="cont btn-btn">Discard</button>

          </a>
          <button name="submitit" id="publish" class="cont btn-btn">Publish</button>
        </div>
        <div class="write write2">
          <input name="title" type="text" class="title-placeholder" placeholder="THIS IS WHERE YOU TYPE YOUR TITTLE" value="<?php if (isset($_GET['post_id']))
                                                                                                                              echo $edit['title'] ?>" required>
        </div>

        <div class="write write3">
          <div></div>
          <input name="image" class="file-btn" type="file" required>
        </div>
        <div class="write write4">
          <textarea id="myEditor" name="blogtext" required>

        </textarea>
        </div>
      </article>
    </form>


  </div>
  <?php
  // Output the variable as a JavaScript string
  echo "<script>var initial_value = '" . addslashes($initial_value) . "';</script>";

  ?>
  <script type="text/javascript" src="../node_modules/froala-editor/js/froala_editor.pkgd.min.js"></script>
  <script src="../javascript/script.js"></script>
  <script>
    // new FroalaEditor('#myEditor', {
    //   toolbarInline: false
    // })

    var editor = new FroalaEditor('#myEditor', {
      // Add the init event to set the initial value
      events: {
        'initialized': function() {
          this.html.set(initial_value);
        }
      }
    });
  </script>
</body>

</html>