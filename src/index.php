<?php
	include_once "constants.php";
	include_once "db.php";
	
	if (isset($_POST["paidby"])) {
		add_item();
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
						/*
						*	Displays the summary of the ledger.
						*/
					
						// Get items from the database.
						$items = get_items();
						
						// Generate a x by x array of zeroes.
						$amount_owing = array();
						for ($i=1; $i<=NUMBER_OF_PEOPLE; $i++) {
							$amount_owing[$i] = array();
							for ($j=1; $j<=NUMBER_OF_PEOPLE; $j++) $amount_owing[$i][$j] = 0;
						}
						
						// Echo the header of the table title.
						echo('
						<table style="width: 100%; text-align: center">
							<tr><td></td><td></td>
						');
						for ($i=1; $i<=NUMBER_OF_PEOPLE; $i++) {
							echo "<td>".constant("PERSON_".$i)."</td>";
						}
						echo "</tr>";

						// Process each item in the ledger.
						for ($j=0; $j<count($items); $j++) {
							$item = $items[$j];

							// Prepare the values from the database.
							$pb = $item["paidby"];
							$v = $item["value"];
							$sb = $item["splitby"];
							
							// Count the number of people the item value is split between.
							$count = 0;
							for ($i=1; $i<=NUMBER_OF_PEOPLE; $i++) {
								if (($sb & (1 << ($i - 1))) != 0) {
									$count++;
								}
							}
							
							// Sum the amount owing to each person.
							for ($i=1; $i<=NUMBER_OF_PEOPLE; $i++) {
								if (($sb & (1 << ($i - 1))) != 0) {
									$amount_owing[$i][$pb] += ($v / $count);
									$amount_owing[$pb][$i] -= ($v / $count);
								}
							}
						}
						
						// Echo each line of the summary.
						for ($i=1; $i<=NUMBER_OF_PEOPLE; $i++) {
							echo "<tr><td>".constant("PERSON_".$i)."</td><td>owes</td>";
							for ($j=1; $j<=NUMBER_OF_PEOPLE; $j++) {
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
					
						// Get items from the database.
						$items = get_items();

						// Echo the header of the table title.
						echo('
						<table style="width: 100%; text-align: center">
							<tr><th style="width: 120px">Date</th><th>Description</th><th>Paid By</th><th>Amount</th><th colspan="'.NUMBER_OF_PEOPLE.'">Split by</th><th>Notes</th></tr>
							<tr><th></th><th></th><th></th><th></th>
						');
						for ($i=1; $i<=NUMBER_OF_PEOPLE; $i++) echo "<th>".constant("PERSON_".$i)."</th>";
						echo "<td></td></tr>";

						// Echo each row item.
						for ($j=0; $j<count($items); $j++) {
							$item = $items[$j];
							echo "<tr><td>".date('d-m-Y', strtotime($item["date"]))."</td><td>".$item["description"]."</td><td>".constant("PERSON_".$item["paidby"])."</td><td>$".$item["value"]."</td>";
							
							// Echo each split-by indicators for each row.
							for ($i=1; $i<=NUMBER_OF_PEOPLE; $i++) {
								if ($item["splitby"] & (1 << ($i - 1))) echo "<td>x</td>";
								else echo "<td></td>";
							}

							echo "<td>".$item["notes"]."</td>";
							echo "</tr>";
						}
					?>
				</div>
				
			</div>
		</div>

	</body>
</html>