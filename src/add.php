<?php
	include_once "constants.php";
	include_once "db.php";
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

		<div data-role="page" id="pgeAdd" data-theme="d">

			<script>
				// On Load Function
				$(function () {

					// On Form Submit
					$("form").submit(function(e){
		
						// Check the description supplied is not nothing.
						if ($("#description").val().length <= 0) {
							alert("Please put a description for the item.");
							e.preventDefault();
							return false;
						}
					});
				});
			</script>

			<div data-role="header">
				<a href="./" data-icon="home" data-iconpos="notext" data-transition="fade"></a><h1><?php echo TITLE ?> Ledger</h1>
			</div>
	
			<div data-role="content">
	
				<form action="index.php" method="POST">

					<div data-role="fieldcontain" id="fieldDescription">
						<label>Description:</label>
						<fieldset data-role="controlgroup">
							<input type="text" id="description" name="description" value="" placeholder="Groceries, Electricity, etc."/>
						</fieldset>
					</div>
			
					<div data-role="fieldcontain" id="fieldDate">
						<label>Date:</label>
						<fieldset data-role="controlgroup">
							<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"/>
						</fieldset>
					</div>
			
					<div data-role="fieldcontain" id="fieldPaidBy">
						<label>Paid by:</label>
						<fieldset data-role="controlgroup">
							<?php
								// Display the housemates.
								$housemates = get_list_housemates();
							
								// Iterate through the housemates.
								for ($i=0; $i<count($housemates); $i++) {
									echo('
								<input type="radio" name="paidby" id="pb_'.$housemates[$i]["housemate_id"].'" class="custom" value="'.$housemates[$i]["housemate_id"].'"/>
								<label for="pb_'.$housemates[$i]["housemate_id"].'">'.$housemates[$i]["housemate_name"].'</label>
									');								
								}
							?>
						</fieldset>
					</div>
				
					<div data-role="fieldcontain" id="fieldSplitBetween">
						<label>Split between:</label>
						<fieldset data-role="controlgroup">
							<?php
								// Iterate through the housemates.							
								for ($i=0; $i<count($housemates); $i++) {
									echo('
								<input type="number" name="pv_'.$housemates[$i]["housemate_id"].'" id="pv_'.$housemates[$i]["housemate_id"].'" class="custom" placeholder="'.$housemates[$i]["housemate_name"].' ($)"/>
								<label for="pv_'.$housemates[$i]["housemate_id"].'">'.$housemates[$i]["housemate_name"].'</label>
									');								
								}
							?>
						</fieldset>
					</div>
					
					<div data-role="fieldcontain" id="fieldNotes">
						<label>Notes:</label>
						<fieldset data-role="controlgroup">
							<textarea id="notes" name="notes"></textarea>
						</fieldset>
					</div>
					
					<input type="submit" value="Add"/>
					
				</form>
	
			</div>
		</div>

	</body>
</html>