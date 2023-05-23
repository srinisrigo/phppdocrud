<?php

function get_titles() {
	return array(
		"Employee",
		"Assistant",
		"Manager",
		"Supervisor",
		"Lawyer"
	);
}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
  }
  
?>