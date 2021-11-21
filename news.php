<?php
include 'functions.php';

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $news = isset($_POST['news']) ? $_POST['news'] : '';
  if (!empty($news)) { 
    $file = fopen("assets/flashnews.txt","w");
    $update = fwrite($file, trim($news));
    fclose($file);   
  }
}
?>

<?=template_header('News')?>
<div class="container mt-5">
    <form action="news.php" method="post" enctype="multipart/form-data">
      <?php $myfile = fopen("assets/flashnews.txt", "r");?>
		  <?php if ($myfile): ?> 
      <div class="input-group">
          <textarea name="news" id="news" class="form-control" rows="15">
          <?= fread($myfile,filesize("assets/flashnews.txt")) ?>
          </textarea>
          <input type="submit" value="submit" name="submit" class="btn btn-light input-group-text">
      </div>
		  <?php endif; ?>
      <?php fclose($myfile);?>
    </form>
</div>

<?=template_footer()?>