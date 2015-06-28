<?php

	include_once "constants.php";

	function clean_string($str_in) {
		$str_out = "";
		
		// Process each character and make sure they are safe.
		for ($i=0; $i<strlen($str_in); $i++) {
			if (ctype_alnum(substr($str_in, $i, 1)) || substr($str_in, $i, 1) == "," || substr($str_in, $i, 1) == " ") {
				$str_out .= substr($str_in, $i, 1);
			}
		}
		
		return $str_out;
	}

	function add_item() {
		// Connect to database.
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

		// Check to see if connection failed.
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		// Get the date, paid-by, and value from the HTTP POST.
		$date = date('Y-m-d', strtotime($_POST["date"]));
		$paidby = intval($_POST["paidby"]);
		$value = floatval($_POST["value"]);

		// Calculate the split-by value from the HTTP POST.
		$splitby = 0;
		for ($i=1; $i<=NUMBER_OF_PEOPLE; $i++) {
			if (isset($_POST["split_person".$i])) {
				$splitby += (1 << ($i - 1));
			}
		}
		
		// Parse and clean description and notes.
		$description_out = clean_string($_POST["description"]);
		$notes_out = clean_string($_POST["notes"]);

		// Generate the SQL query for insertion.
		$sql = "INSERT INTO ledger (date, description, paidby, value, splitby, notes) VALUES (\"$date\", \"$description_out\", $paidby, $value, $splitby, \"$notes_out\")";

		// Process query.
		if (!$conn->query($sql)) die("Unable to insert into database: " . $conn->connect_error);

		// Close db connection.
		$conn->close();
	}

	function get_items() {
		$items_out = array();
	
		// Connect to database.
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

		// Check to see if connection failed.
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		// Generate the SQL query for insertion.
		$sql = "SELECT * FROM ledger WHERE 1 ORDER BY date DESC";

		// Process query.
		$result = $conn->query($sql);
		
		// Process results.
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($items_out, $row);
			}
		}

		// Close db connection.
		$conn->close();
		
		return $items_out;
	}

?>
