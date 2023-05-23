<?php
include '../template.php';
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE contacts SET phone = ? WHERE id = ?');
        $stmt->execute([$phone, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="row mt-5">
    <div class="col">
    </div>
    <div class="col">
        <div class="row">
            <div class="col">Title</div>
            <div class="col"><?=$contact['title']?></div>
        </div>
        <div class="row">
            <div class="col">Name</div>
            <div class="col"><?=$contact['name']?></div>
        </div>  
        <div class="row">
            <div class="col">Email</div>
            <div class="col"><?=$contact['email']?></div>
        </div> 
        <div class="row">
            <div class="col">Created</div>
            <div class="col"><?=date('Y-m-d\TH:i', strtotime($contact['created']))?></div>
        </div> 
        <form action="update.php?id=<?=$contact['id']?>&page=<?=$page?>" method="post">
        <div class="row">
            <div class="col">Phone</div>
            <div class="col">
                <input type="text" name="phone" placeholder="2025550143" value="<?=$contact['phone']?>" id="phone"> 
            </div>
        </div> 
        <div class="w-100"></div>
        <div class="row mt-3">
            <div class="col"></div>
            <div class="col">
                <input class="btn btn-success" type="submit" value="Update">
                <a class="btn btn-danger" href="index.php?page=<?=$page?>">Cancel</a>
            </div>  
        </div>   
        </form>              
    </div>
    <div class="col">
    </div>
</div>

<?=template_footer()?>
