<?php

	require_once "constants.php";

	// Clean the string supplied and return it to the user.
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

	// Insert an item into the database.
	function insert_item($sql) {
		$insert_id = -1;
	
	echo $sql;
		// Connect to database.
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		
		// Check to see if connection failed.
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		// Process query.
		if (!$conn->query($sql)) die("Unable to insert into database: " . $conn->connect_error);

		// Get the insert id.
		$insert_id = $conn->insert_id;

		// Close db connection.
		$conn->close();	
		
		// Return the insert id.
		return $insert_id;
	}

	// Queries the SQL database and returns the rows.
	function query_items($sql) {
		$items_out = array();
	
		// Connect to database.
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

		// Check to see if connection failed.
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

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

	// Adds an ledger item to the database.
	function add_ledger_item() {
		// Keep track of insert id for specific costings.
		$item_id = -1;
	
		if (!(isset($_POST["date"]) && isset($_POST["description"]) && isset($_POST["notes"]) && isset($_POST["paidby"]))) return -1;
	
		// Get the date, and paid-by from the HTTP POST.
		$date = date('Y-m-d', strtotime($_POST["date"]));
		$paidby = intval($_POST["paidby"]);
		
		// Parse and clean description and notes.
		$description_out = clean_string($_POST["description"]);
		$notes_out = clean_string($_POST["notes"]);

		// Generate the SQL query for insertion.
		$sql = "INSERT INTO ledger (date, description, paidby, notes) VALUES (\"$date\", \"$description_out\", $paidby, \"$notes_out\")";

		// Insert item.
		$item_id = insert_item($sql);
		
		// Add item costings.
		if ($item_id > 0) add_item_costings($item_id);
		
		// Return success.
		return 1;
	}

	// Adds the costings for the ledger item to the database.
	function add_item_costings($id) {
		// Gets the list of housemates.
		$housemates = get_list_housemates();
		
		// Get the values from the POST values.
		for ($i=0; $i<count($housemates); $i++) {
			$housemate_id = $housemates[$i]["housemate_id"];
			$housemate_value = "pv_".$housemate_id;
			if (isset($_POST[$housemate_value])) $housemates[$i]["value"] = floatval($_POST[$housemate_value]);
			else $housemates[$i]["value"] = 0;
		}
		
		// Push all values into the database.
		for ($i=0; $i<count($housemates); $i++) {
			$sql = 'INSERT INTO costings (lkey, housemate_id, value) VALUES ('.$id.', '.$housemates[$i]["housemate_id"].', '.$housemates[$i]["value"].');';
			insert_item($sql);
		}
	}

	// Gets the ledger records.
	function get_ledger_items() {
		return query_items("SELECT * FROM ledger NATURAL JOIN costings WHERE 1 ORDER BY date DESC, lkey ASC, housemate_id ASC");
	}
	
	// Gets the list of housemates.
	function get_list_housemates() {
		return query_items("SELECT * FROM housemates WHERE 1 ORDER BY housemate_id ASC");
	}

?>
