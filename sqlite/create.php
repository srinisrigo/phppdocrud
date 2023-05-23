<?php
include '../template.php';
include 'functions.php';
include '../utility/country_codes.php';
include '../utility/index.php';
$pdo = pdo_connect_sqlite();
$msg = '';
$nameErr = "";
$emailErr = "";
$titleErr = "";
$countryErr = "";
$phoneErr = "";
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$title = isset($_POST['title']) ? $_POST['title'] : '';
$country = isset($_POST['country']) ? $_POST['country'] : '';
$created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
$titles = get_titles();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Check if POST data is not empty
if (!empty($_POST)) {
    $is_valid = true;
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    if (empty($_POST["name"])) {
        $nameErr = "*";
      $is_valid = false;
    } else if (!preg_match("/^[a-zA-Z-' ]*$/",test_input($name))) {
      $nameErr = "only letters and white space allowed";
      $is_valid = false;
    }
    if (empty($_POST["email"])) {
        $emailErr = "*";
      $is_valid = false;
      } else if (!filter_var(test_input($email), FILTER_VALIDATE_EMAIL)) {
      $emailErr = "invalid e-mail format";
      $is_valid = false;
    }
    if (empty($_POST["title"]) || test_input($title) === -1) {
        $titleErr = "*";
      $is_valid = false;
    }
    if (empty($_POST["country"]) || test_input($country) === -1) {
        $countryErr = "*";
      $is_valid = false;
    }
    $iso = get_country_code_iso($country);
    if (empty($_POST["phone"])) {
        $phoneErr = "*";
      $is_valid = false;
    } else if (!preg_match(get_country_code_preg_match(test_input($country)),test_input($phone))) {
      $phoneErr = "invalid phone code";
      $is_valid = false;
    }
    if ($is_valid) {
        // Insert new record into the contacts table
        $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$id, $name, $email, $phone, $title, $created]);
        // Output message
        $msg = 'Created Successfully!';
    }
}
?>
<?=template_header('Create')?>

<div class="row">
    <div class="col">
    </div>
    <div class="col">
      <form action="create.php?page=<?=$page?>" method="post">
          <div class="form-group">
            <?php if ($msg): ?>
            <p><?=$msg?></p>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="title">Title</label>
            <?php if ($titleErr): ?>
            <label class="text-danger small"><?=$titleErr?></label>
            <?php endif; ?>
            <select name="title" id="title" class="form-control <?=!empty($titleErr)? 'is-invalid':''?>">
                <option value="-1" disabled selected hidden>Title</option>
                <?php foreach ($titles as $item): ?>
                <option value="<?=$item?>" <?php if ($title === $item): ?> selected <?php endif; ?> ><?=$item?></option>
                <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="name">Name</label>
            <?php if ($nameErr): ?>
            <label class="text-danger small"><?=$nameErr?></label>
            <?php endif; ?>
            <input class="form-control <?=!empty($nameErr)? 'is-invalid':''?>" type="text" name="name" placeholder="eg: John Doe" id="name" <?php if ($name): ?>value="<?=$name?>" <?php endif; ?> >
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <?php if ($emailErr): ?>
            <label class="text-danger small"><?=$emailErr?></label>
            <?php endif; ?>
            <input class="form-control <?=!empty($emailErr)? 'is-invalid':''?>" type="text" name="email" placeholder="eg: johndoe@example.com" id="email" <?php if ($email): ?>value="<?=$email?>" <?php endif; ?> >
          </div>
          <div class="form-group">
            <label for="country">Country</label>
            <?php if ($countryErr): ?>
            <label class="text-danger small"><?=$countryErr?></label>
            <?php endif; ?>
            <select name="country" id="country" class="form-control <?=!empty($countryErr)? 'is-invalid':''?>">
                <option value="-1" disabled selected hidden>Country</option>
                <?php foreach ($country_codes as $country_code): ?>
                <option value="<?=$country_code['code']?>" <?php if ($country === $country_code['code']): ?> selected <?php endif; ?>><?=$country_code['name'].'('.$country_code['code'].')'?></option>
                <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <?php if ($phoneErr): ?>
            <label class="text-danger small"><?=$phoneErr?></label>
            <?php endif; ?>
            <input class="form-control <?=!empty($phoneErr)? 'is-invalid':''?>" type="text" name="phone" placeholder="eg: 2025550143" id="phone" <?php if ($phone): ?>value="<?=$phone?>" <?php endif; ?> >
          </div>
          <div class="form-group">
            <input class="btn btn-success" type="submit" value="Create">
            <a class="btn btn-danger" href="read.php?page=<?=$page?>">Cancel</a>   
          </div>
      </form>
    </div>
    <div class="col">
    </div>
  </div>

<?=template_footer()?>
