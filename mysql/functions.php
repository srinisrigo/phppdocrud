<?php
ini_set('display_errors', 1);  
error_reporting(E_ALL); 
$is_dir_prefix = true;
function pdo_connect_mysql() {
    try {
    	$pdo = new PDO('mysql:host=localhost;charset=utf8', 'admin', 'admin');
		createDatabase($pdo);
		createTables($pdo);
		mockContacts($pdo);
		return $pdo;
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}

function createDatabase($pdo) {
    $pdo->query("CREATE DATABASE IF NOT EXISTS pdocrud");
    $pdo->query("use pdocrud");
	echo console_log("database were created.");
}

function createTables($pdo) {
    $pdo->query("CREATE TABLE IF NOT EXISTS `contacts` ( `id` int(11) NOT NULL AUTO_INCREMENT,   `name` varchar(255) NOT NULL,   `email` varchar(255) NOT NULL,   `phone` varchar(255) NOT NULL,   `title` varchar(255) NOT NULL,   `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	echo console_log("contacts table were created.");
}

function mockContacts($pdo) {
	$num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
	if ($num_contacts <= 0) {
        $stmt = $pdo->prepare('INSERT INTO contacts(name, email, phone, title, created) VALUES (?, ?, ?, ?, ?)');
		$stmt->execute(array('John Doe', 'johndoe@example.com', '2026550143', 'Lawyer', '2019-05-08 17:32:00'));
		$stmt->execute(array('David Deacon', 'daviddeacon@example.com', '2025550121', 'Employee', '2019-05-08 07:28:44'));
		$stmt->execute(array('Sam White', 'samwhite@example.com', '2004550121', 'Employee', '2019-05-08 11:29:27'));
		$stmt->execute(array('Colin Chaplin', 'colinchaplin@example.com', '2022550178', 'Supervisor', '2019-05-08 03:29:27'));
		$stmt->execute(array('Ricky Waltz', 'rickywaltz@example.com', '7862342390', '', '2019-05-09 19:16:00'));
		$stmt->execute(array('Arnold Hall', 'arnoldhall@example.com', '5089573579', 'Manager', '2019-05-09 09:17:00'));
		$stmt->execute(array('Toni Adams', 'alvah1981@example.com', '2603668738', '', '2019-05-09 09:19:00'));
		$stmt->execute(array('Donald Perry', 'donald1983@example.com', '7019007916', 'Employee', '2019-05-09 09:20:00'));
		$stmt->execute(array('Joe McKinney', 'nadia.doole0@example.com', '6153353674', 'Employee', '2019-05-09 19:20:00'));
		echo console_log("contacts table were inserted.");
	}
}

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log('.json_encode($output, JSON_HEX_TAG).');';
    if ($with_script_tags) {
        $js_code = '<script>'.$js_code.'</script>';
    }
    echo $js_code;
}
?>