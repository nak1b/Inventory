<?php

//Includeing the library file
require "library.php";

//setting and defining variable to empty string for repopulating the field
$item_name = $description = $supplier_code = $cost = $sell_price = $num_on_hand = $reorder_point = "";
$back_order = "N";
$item_nameErr = $descriptionErr = $supplier_codeErr = $costErr = $sell_priceErr = $num_on_handErr = $reorder_pointErr  = "";
$valid = true;


if($_POST)
{
	//obtainging all the field value 
	
	if(isset($_POST["item_name"]))
		$item_name = htmlspecialchars(trim($_POST["item_name"]));

	if(isset($_POST["description"]))
		$description = htmlspecialchars(trim($_POST["description"]));

	if(isset($_POST["supplier_code"]))
		$supplier_code = htmlspecialchars(trim($_POST["supplier_code"]));

	if(isset($_POST["cost"]))
		$cost = htmlspecialchars(trim($_POST["cost"]));

	if(isset($_POST["sell_price"]))
		$sell_price = htmlspecialchars(trim($_POST["sell_price"]));

	if(isset($_POST["num_on_hand"]))
		$num_on_hand = htmlspecialchars(trim($_POST["num_on_hand"]));

	if(isset($_POST["reorder_point"]))
		$reorder_point = htmlspecialchars(trim($_POST["reorder_point"]));

	if(isset($_POST["back_order"]))
		$back_order = "Y";

	 //validating item name
	$pattern = "/^[ ]*[a-zA-z0-9:\-;', ]+[ ]*$/";
	validate($pattern, $item_name, $item_nameErr, "Enter valid item name", $valid);
	
	//validating item description
	$pattern = "/^[ ]*[a-zA-z0-9:;'\.,\- ]+[ ]*$/";
	validate($pattern, $description, $descriptionErr, "Enter appropriate item desctiption", $valid);

	//validating supplier code
	$pattern = "/^[ ]*[a-zA-z0-9\- ]+[ ]*$/";
	validate($pattern, $supplier_code, $supplier_codeErr, "Supplier code is not valid", $valid);

	//validating cost
	$pattern = "/^[ ]*[0-9]+\.[0-9]{2}[ ]*$/";
	validate($pattern, $cost, $costErr, "Enter valid cost (two decimal allowed)", $valid);
	validate($pattern, $sell_price, $sell_priceErr, "Enter valid price (two decimal allowed)", $valid);

	//validating num on hand and reorder point
	$pattern = "/^[ ]*[0-9]+[ ]*$/";
	validate($pattern, $num_on_hand, $num_on_handErr, "Only numbers are allowed", $valid);
	validate($pattern, $reorder_point, $reorder_pointErr, "Only numbers are allowed", $valid);	
}
	
if($_POST &&  $valid)
{
	insert_value($item_name, $description, $supplier_code, $cost, $sell_price, $num_on_hand, $reorder_point, $back_order);
		
	echo "DATA IS VALID";
}
else
{ ?>
	<!DOCTYPE HTML>
	<html>
		<head>
			<title>Store</title>
			<style type="text/css">
				.error{
					color:red;
				}
			</style>
		</head>
	</html>

	<body>
		<form method="POST" action="">
			<table>
				<tr>
					<td>Item Name: </td>
					<td><input name="item_name" value="<?php echo $item_name; ?>"></td>
					<?php print_error($item_nameErr); ?>
				</tr>

				<tr>
					<td>Description: </td>
					<td><textarea  name="description"><?php echo $description; ?></textarea></td>
					<?php print_error($descriptionErr); ?>
				</tr>

				<tr>
					<td>Supplier Code: </td>
					<td><input name="supplier_code" value="<?php echo $supplier_code; ?>"></td>
					<?php print_error($supplier_codeErr); ?>
				</tr>

				<tr>
					<td>Cost: </td>
					<td><input name="cost" value="<?php echo $cost; ?>"></td>
					<?php print_error($costErr); ?>
				</tr>

				<tr>
					<td>Selling Price: </td>
					<td><input  name="sell_price" value="<?php echo $sell_price; ?>"></td>
					<?php print_error($sell_priceErr); ?>
				</tr>

				<tr>
					<td>Number On Hand: </td>
					<td><input name="num_on_hand" value="<?php echo $num_on_hand; ?>"></td>
					<?php print_error($num_on_handErr); ?>
				</tr>

				<tr>
					<td>Reordered Point: </td>
					<td><input name="reorder_point" value="<?php echo $reorder_point; ?>"></td>
					<?php print_error($reorder_pointErr); ?>
				</tr>

				<tr>
					<td>On Back Order: </td>
					<td><input type="checkbox" name="back_order" <?php if($_POST && $back_order=='Y') echo "checked"; ?>></td>
				</tr>

			</table>
			<input type="submit">
		</form>
	</body>
<?php 
}
?>