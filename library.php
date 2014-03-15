<?php

/*
|---------------------------------------------------------------
| Printing error message if form is posted
|---------------------------------------------------------------
*/
function print_error($error)
{
	if($_POST)
	{
		echo "<td class='error'>";
		echo $error;
		echo "</td>";
	}
}

/*
|---------------------------------------------------------------------------
| Checking if the inputed data match the pattern if not setting up the
| error message and changing validity to false
|---------------------------------------------------------------------------
*/
function validate($pattern, $field, &$errorField, $error, &$valid)
{
	 if(!preg_match($pattern, $field) || empty($field))
	 {
	 	$errorField = $error;
	 	$valid = false;
	 }
	 	
}

/*
|-----------------------------------------------------------------
| Connecting to the database 
|-----------------------------------------------------------------
*/
function db_connect()
{
	$connection = new PDO("mysql:host=localhost; dbname=store", "root", "root");
	return $connection;
}

/*
|---------------------------------------------------------------------------------------
| Connecting to the database and inserting the user provide value in to the database
|---------------------------------------------------------------------------------------
*/
function insert_value($item_name, $description, $supplier_code, $cost, $sell_price, $num_on_hand, $reorder_point, $back_order)
{
	
	$connection = db_connect();
	$sql = 'INSERT INTO inventory (itemName, description, supplierCode, cost, price, onHand, reorderPoint, backOrder) 
				VALUES(:itemName, :description, :supplierCode, :cost, :price, :onHand, :reorderPoint, :backOrder);';
	$prepare = $connection->prepare($sql);

	$prepare->execute(array(
		":itemName" => $item_name,
		":description" => $description,
		":supplierCode" => $supplier_code,
		":cost" => $cost,
		":price" => $sell_price,
		":onHand" => $num_on_hand,
		":reorderPoint" => $reorder_point,
		":backOrder" => $back_order,
		));
}

/*
|---------------------------------------------------------------------------------------
| Connecting to the database and displaying the database entries in form of table
|---------------------------------------------------------------------------------------
*/
function view_data()
{
	$connection = db_connect();
	$results = $connection->query('SELECT * FROM inventory');
	foreach ($results as $row)
	{
		echo "<tr>";
		echo "<td>". $row["id"] . " </td>";
		echo "<td>". $row["itemName"] . " </td>";
		echo "<td>". $row["description"] . " </td>";
		echo "<td>". $row["supplierCode"] . " </td>";
		echo "<td>". $row["cost"] . " </td>";
		echo "<td>". $row["price"] . " </td>";
		echo "<td>". $row["onHand"] . " </td>";
		echo "<td>". $row["reorderPoint"] . " </td>";
		echo "<td>". $row["backOrder"] . " </td>";
		if($row["deleted"]=="n")
			echo "<td><a href='delete.php?id={$row["id"]}'>Delete</a></td>";
		else
			echo "<td><a href='delete.php?id={$row["id"]}'>Restore</a></td>";
		echo "</tr>";
	}
}

/*
|---------------------------------------------------------------------------------------
| Connecting to the database and updating the deleted column appropriately
|---------------------------------------------------------------------------------------
*/
function delete_field()
{
	$connection = db_connect();
	$results = $connection->query('SELECT * FROM inventory where id=' . $connection->quote($_GET["id"]));

	foreach ($results as $row) {
		if($row["deleted"]=="y")
			$stmt = $connection->prepare('UPDATE inventory SET deleted="n" WHERE id=:id');
		else
			$stmt = $connection->prepare('UPDATE inventory SET deleted="y" WHERE id=:id');
	$stmt->execute(array(
		'id' => $_GET["id"]
	    ));
	}
}

?>