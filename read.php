<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY name LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
?>
<?=template_header('Read')?>

<div>
	<table class="table table-bordered table-hover mt-5">
        <thead>
            <tr class="bg-light">
                <td><a href="create.php?page=<?=$page?>" class="create-contact"><img src="assets/icons/vector-pen.svg" alt="create"/></a></td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Title</td>
                <td>Created</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td class="actions">
                    <a href="update.php?id=<?=$contact['id']?>&page=<?=$page?>"><img src="assets/icons/pencil.svg" alt="update"/></a>
                    <a href="delete.php?id=<?=$contact['id']?>&page=<?=$page?>"><img src="assets/icons/trash.svg" alt="delete"/></a>
                </td>
                <td><?=$contact['name']?></td>
                <td><?=$contact['email']?></td>
                <td><?=$contact['phone']?></td>
                <td><?=$contact['title']?></td>
                <td><?=$contact['created']?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <ul class="pagination justify-content-center">
		<?php if ($page > 1): ?>
        <li class="page-item">
		    <a class="page-link" href="read.php?page=<?=$page-1?>"><img src="assets/icons/arrow-left.svg" alt="previous"/></a>
        </li>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
        <li class="page-item">
		    <a class="page-link" href="read.php?page=<?=$page+1?>"><img src="assets/icons/arrow-right.svg" alt="next"/></a>
        </li>
		<?php endif; ?>
    </ul>
</div>

<?=template_footer()?>
