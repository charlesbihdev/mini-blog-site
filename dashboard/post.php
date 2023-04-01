<?php

if (isset($_SESSION['user_id'])) {
  $userid = $_SESSION['user_id'];
} else {
  header('location: ../login.php');
}

?>

<article class="item item3 active interface " id="tab1">
  <div class="post-available">
    <div class="purple-design">
      <h1>AVAILABLE POSTS</h1>
    </div>
  </div>
  <div style="color: gray; display: <?php echo $available ?>">
    <div style="display: flex; justify-content: space-around">
      <i style="font-size: 11em; " class="fa-solid fa-circle-exclamation"> </i>
    </div>
    <h1 style="text-align: center; margin-top: 20px">
      Awww😟😟!!... No post available yet
    </h1>
  </div>
  <?php foreach ($RS as $post) {
    $fetched_post = $post['post'];
    $decode = html_entity_decode($fetched_post);
    $stripped = strip_tags($decode);
    $final_except = substr($stripped, 0, 235);

  ?>
    <!-- Individual post on dashboard -->


    <div class=" container cont">
      <div class="child child1">
        <img class="post-img" src="<?php echo $post['image']; ?>">
      </div>

      <div class="child child2">
        <h2 class="post-heading">
          <?php echo $post['title']; ?>
        </h2>
        <div class="main-post">
          <?php
          echo $final_except;
          ?>
        </div>

        <div class="flex-roww">
          <p class="blogger-name"><?php echo $post['firstname'] . " " . $post['lastname']; ?></p>
          <p class="post-date">
            <?php
            $date_time = new DateTime($post['created_at']);
            $date_only = $date_time->format('d/m/Y');
            echo $date_only; ?></p>
        </div>
      </div>

      <div class="child child3">
        <a href="../<?php echo $post['slug'] ?>" target="_blank">
          <i class="fa-solid fa-eye view icons"></i>
        </a>
        <a href="./create-post.php?post_id=<?php echo $post['post_id'] ?>">
          <i class="fa-solid fa-pen-to-square edit icons"></i>
        </a>

        <a href="./delete-post.php?post_id=<?php echo $post['post_id'] ?>">
          <i class="fa-solid fa-trash-can deleted icons"></i>
        </a>
      </div>
    </div>

  <?php } ?>
  <!-- End of Individual post on dashboard -->
</article>