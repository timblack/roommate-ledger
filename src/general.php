<?php

	// Finds the array position of the housemate supplied.
	function get_housemate_arr_position($housemates, $id) {
		for ($i=0; $i<count($housemates); $i++) {
			if ($housemates[$i]["housemate_id"]==$id) return $i;
		}
		return -1;
	}
	
	// Generates a zero array x by x for the housemates.
	function generate_zero_array($arrIn) {
		// Generate a x by x array of zeroes.
		$arrOut = array();
		for ($i=0; $i<count($arrIn); $i++) {
			$arrOut[$i] = array();
			for ($j=0; $j<count($arrIn); $j++) $arrOut[$i][$j] = 0;
		}
		
		return $arrOut;
	}

	// Calculates the totals array for the housemates.
	function calculate_totals($housemates, $items) {
		$amount_owing = generate_zero_array($housemates);
	
		// Process each item in the ledger.
		for ($j=0; $j<count($items); $j++) {
			$item = $items[$j];

			// Prepare the values from the database.
			$pb = get_housemate_arr_position($housemates, $item["paidby"]);
			$v = $item["value"];
			$hid = get_housemate_arr_position($housemates, $item["housemate_id"]);
								
			// Sum the amount owing to each person.
			$amount_owing[$hid][$pb] += $v;
			$amount_owing[$pb][$hid] -= $v;
		}
		
		return $amount_owing;
	}
	
?>