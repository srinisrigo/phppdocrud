<?php
include 'functions.php';
// Your PHP code here.

// Home Page template below.
?>

<?=template_header('Home')?>

<div class="container mt-5">
  <div class="row">
    <div class="col-sm">
      <div class="">
          <p class="h4">About Us</p>
          <hr class="my-4">
          <p class="h6">Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in.</p>
          <p class="h6">This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem</p>
      </div>
    </div>
    <div class="col-sm">
      <?php $images = glob("assets/image/*.*"); ?>
      <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" data-interval="3000" data-pause="false">
        <div class="carousel-inner">
          <?php foreach ($images as $key => $image): ?>
          <div class="carousel-item <?= (!$key)?'active':'' ?>">
            <img class="img-fluid" src="<?=$image?>" alt="slide">
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="col-sm border">
      <?php $myfile = fopen("assets/flashnews.txt", "r");?>
		  <?php if ($myfile): ?>   
        <marquee scrollamount="1" direction="up" loop="true">
          <p><small><?= nl2br(fread($myfile,filesize("assets/flashnews.txt"))) ?></small></p>
        </marquee>
		  <?php endif; ?>
      <?php fclose($myfile);?>   
    </div>
  </div>
</div>
<div class="alert alert-warning alert-dismissible fade show mt-5" role="alert">
  <strong>Holy guacamole!</strong> You should check in on some of those fields below.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?=template_footer()?>