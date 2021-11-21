<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the contact!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php?page='.$page);
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="row mt-5">
    <div class="col">
    </div>
    <div class="col">
        <ul class="list-group list-group-flush">
            <?php if ($msg): ?>
            <p><?=$msg?></p>
            <?php else: ?>
            <li class="list-group-item">
                <small>Are you sure you want to delete?</small>
                <label class="h4"><?=$contact['email']?></label>
            </li>
            <li class="list-group-item">
                <a class="btn btn-success" href="delete.php?id=<?=$contact['id']?>&confirm=yes&page=<?= $page ?>">Yes</a>
                <a class="btn btn-danger" href="read.php?page=<?=$page?>">No</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="col">
    </div>
</div>

<?=template_footer()?>
