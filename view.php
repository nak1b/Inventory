<?php

require "library.php"

?>

<html>
<head>
	<style type="text/css">
	table
	{
		border-collapse:collapse;
	}
	table,th, td
	{
		border: 1px solid black;
		padding: 5px;
	}
	</style>
</head>
<body>
<table>
	<tr>
		<th>ID</th>
		<th>Item Name</th>
		<th>Description</th>
		<th>Supplier</th>
		<th>Cost</th>
		<th>Price</th>
		<th>Number On Hand</th>
		<th>Reorder Level</th>
		<th>On Back Order?</th>
		<th>Delete/Restore</th>
	</tr>
<?php view_data(); ?>
</table>
</body>
</html>
