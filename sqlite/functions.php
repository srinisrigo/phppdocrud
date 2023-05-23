<?php 
    /** 
     * https://renenyffenegger.ch/notes/development/web/php/snippets/sqlite/index
     */  
ini_set('display_errors', 1);  
error_reporting(E_ALL); 
$is_dir_prefix = true;
class Config {  
    /** 
     * path to the sqlite file 
     */  
     const PATH_TO_SQLITE_FILE = 'phpsqlite.db';  
    
 }  
class SQLiteConnection {  
    /** 
     * PDO instance 
     * @var type  
     */  
    private $pdo;  
   
    /** 
     * return in instance of the PDO object that connects to the SQLite database 
     * @return \PDO 
     */  
    public function connect() {  
        if ($this->pdo == null) {  
            $this->pdo = new \PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);  
        }  
        return $this->pdo;  
    }  
}  
function pdo_connect_sqlite() {
    try {
		$pdo = (new SQLiteConnection())->connect();  
		if ($pdo != null)  
			echo console_log('Connected to the SQLite database successfully!');  
		else  
			echo console_log('Whoops, could not connect to the SQLite database!');
    	return $pdo;
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
		// throw new pdoDbException($exception);
    	// exit('Failed to connect to database!');
    	exit($exception);
    }
}

function createTables($pdo) {
	$pdo->exec('CREATE TABLE IF NOT EXISTS contacts (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR(80), email VARCHAR(180), phone VARCHAR(80), title VARCHAR(50), created DATETIME)');
	echo console_log("contacts table were created.");
}

function mockContacts($pdo) {
	$num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
	if ($num_contacts <= 0) {
		$stmt = $pdo->prepare('INSERT INTO contacts(name, email, phone, title, created) VALUES (:name, :email, :phone, :title, :created)');
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