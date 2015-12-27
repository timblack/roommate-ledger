<?php
	include_once "constants.php";
	include_once "db.php";
	
	// If there is something in the post request, 
	if (isset($_POST["paidby"])) {
		add_ledger_item();
	}
?>

<!DOCTYPE html> 
<html> 
	<head> 
		<title><?php echo TITLE ?> Ledger</title> 
	
		<meta name="viewport" content="width=device-width, initial-scale=1" /> 

		<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="css/styles.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery.mobile.flatui.css" />	
	
		<script src="js/jquery/jquery-1.11.1.min.js"></script>
		<script src="js/jquery/jquery.mobile-1.4.5.min.js"></script>
	</head> 
	<body> 

		<div data-role="page" id="pgeHome" data-theme="d">

			<div data-role="header">
				<a href="./" data-icon="home" data-iconpos="notext" data-transition="fade"></a><h1><?php echo TITLE ?> Ledger</h1>
			</div>
	

			<div data-role="content">
					<?php
						require_once "general.php";
					
						/*
						*	Displays the summary of the ledger.
						*/
					
						// Get items from the database.
						$items = get_ledger_items();
						$housemates = get_list_housemates();
						$amount_owing = calculate_totals($housemates, $items);
						
						// Echo the header of the table title.
						echo('
						<table style="width: 100%; text-align: center">
							<tr><td></td><td></td>
						');
						for ($i=0; $i<count($housemates); $i++) {
							echo "<td>".$housemates[$i]["housemate_name"]."</td>";
						}
						echo "</tr>";
						
						// Echo each line of the summary.
						for ($i=0; $i<count($housemates); $i++) {
							echo "<tr><td>".$housemates[$i]["housemate_name"]."</td><td>owes</td>";
							for ($j=0; $j<count($housemates); $j++) {
								if ($i != $j) {
									if ($amount_owing[$i][$j] > 0) {
										echo "<td>$".round($amount_owing[$i][$j], 2, PHP_ROUND_HALF_DOWN)."</td>";
									} else echo "<td>----</td>";
								} else echo "<td>n/a</td>";
							}
						}
					?>
				</table><br/><br/>
	
				<a href="add.php" class="ui-btn">Add Item to Ledger</a><br/><br/>
				
				<div>
					<?php
						/*
						*	Displays the items in the ledger.
						*/

						// Echo the header of the table title.
						echo('
						<table style="width: 100%; text-align: center">
							<tr><th style="width: 120px">Date</th><th>Description</th><th>Paid By</th><th colspan="'.count($housemates).'">Split by</th><th>Notes</th></tr>
							<tr><th></th><th></th><th></th>
						');
						for ($i=0; $i<count($housemates); $i++) echo "<th>".$housemates[$i]["housemate_name"]."</th>";
						echo "<td></td></tr>";

						// Set the initial ledger key.
						$lkey = -1;
						$newline = false;
						$hm_count = 0;

						// Echo each row item.
						for ($j=0; $j<count($items); $j++) {
							$item = $items[$j];
							
							// Echo the line (if the ledger key changes, its a new item).
							if ($item["lkey"] != $lkey) $newline = true;
							else $newline = false;
							
							// If it is a new line, echo the details of the ledger item.
							if ($newline) {						
								echo "<tr><td>".date('d-m-Y', strtotime($item["date"]))."</td><td>".$item["description"]."</td><td>".$housemates[get_housemate_arr_position($housemates, $item["paidby"])]["housemate_name"]."</td>";
								$lkey = $item["lkey"];
								$hm_count = 0;
							}
							
							// Echo each split-by indicators for each row.
							while ($hm_count<get_housemate_arr_position($housemates, $item["housemate_id"])) {
								echo "<td></td>";
								$hm_count++;
							}
							if (get_housemate_arr_position($housemates, $item["housemate_id"])==$hm_count) {
								echo "<td>$".round($item["value"],2)."</td>";
								$hm_count++;
							}
							
							if (!$newline) {
								$endline = false;

								// If it is the last item, or the ledger key changes, it is a new line.
								if ($j==(count($items)-1)) $endline = true;
								else $endline = ($items[$j+1]["lkey"] != $lkey);

								// If it is the end of a line, pad out the table, and echo the notes.
								if ($endline) {
									while ($hm_count<count($housemates)) {
										echo "<td></td>";
										$hm_count++;
									}
									echo "<td>".$item["notes"]."</td>";
									echo "</tr>";
								}
							}
						}
					?>
				</div>
			</div>
		</div>

	</body>
</html>