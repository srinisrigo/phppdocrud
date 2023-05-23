<?php
include 'template.php';
$msg = '';
$image = isset($_GET['image']) && is_string($_GET['image']) ? $_GET['image'] : '';
if (!empty($image)) { 
  unlink($image);  
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $target_dir = "assets/image/";
    $target_file = $target_dir . basename($_FILES["carousel"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["carousel"]["tmp_name"]);
    if($check !== false) {
        $msg = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $msg = "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      $msg = "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["carousel"]["size"] > 500000) {
      $msg = "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $msg = "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["carousel"]["tmp_name"], $target_file)) {
        $msg = "The file ". htmlspecialchars( basename( $_FILES["carousel"]["name"])). " has been uploaded.";
      } else {
        $msg = "Sorry, there was an error uploading your file.";
      }
    }
}
?>

<?=template_header('Carousel')?>
<div class="container mt-5">
    <form action="image.php" method="post" enctype="multipart/form-data">
      <div class="input-group mb-3">
        <input type="file" class="form-control" name="carousel" id="carousel">
        <input type="submit" value="Upload" name="submit" class="btn btn-light input-group-text">
      </div>
      <?php if ($msg): ?>
      <p><?=$msg?></p>
      <?php endif; ?>
    </form>
    <?php $images = glob("assets/image/*.*"); ?>
    <?php foreach ($images as $key => $image): ?>
    <div class="card float-left m-3">
        <img class="card-img-top" src="<?=$image?>" style="height: 160px;">
        <div class="card-img-overlay">
        <a class="h2" href="image.php?image=<?=$image?>"><img src="assets/icons/trash.svg" alt="delete"/></a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?=template_footer()?>