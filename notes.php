<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php
  if (isset($_POST['submit'])) {
    echo gettype(($_FILES['image']['type']));
  }
  //   echo '<script>
  //   var result = confirm("Are you sure you want to delete this file?");
  //   if (result) {
  //     alert("File deleted.");
  //   } else {
  //     alert("File not deleted.");
  //   }
  // </script>';
  //     }
  ?>

</head>

<body>
  <form method="POST" action="./notes.php" enctype="multipart/form-data">

    <div>
      <p id="show" class="small-text11"> Upload Profile Picture</p>

      <input class="input2 files" type="file" name="image" placeholder="myFileInput" value="insert image">
    </div>
    <div>
      <input class="input2 submit" type="submit" name="submit" value="Sumit">
    </div>
  </form>

</body>

</html>