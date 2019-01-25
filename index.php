<?php
require "./public/templates/header.php";

try {

    require "./config.php";
    require "./common.php";

    // $connection = new PDO ( $dsn, $username, $password, $options );
    $connection = new PDO($dsn);
    $sql = "SELECT * FROM Coverage ORDER BY CoverageName ASC, Cost ASC";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<section>
<h2>Coverage Information</h2>
<button class="btn btn-primary"><a href="install.php">Install Database</a></button>
<button class="btn btn-primary"><a href="create.php">Create new Coverage</a></button>
<button class="btn btn-primary"><a href="search.php">Search</a></button>
<input class="btn btn-primary" type="button" id="Developers" value="Developers" />
<div id="stage" style="float: right;"> </div>

<input class="btn btn-primary" type="button" id="Tcost" value="Total Cost" />
<div id="stage" style="float: right;"> </div>

<?php
 try{
    $connection = new PDO($dsn);
    $sql = "SELECT SUM(Cost) AS total FROM Coverage";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $Totalcost = $statement->fetch(PDO::FETCH_ASSOC);
 }catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<script>
    $(document).ready(function() {
	$("#Tcost").click(function(event) {
	   $.ajax({
		   success : function(data) {
		    $('#stage').html('<p> Total cost is: '+<?php echo escape($Totalcost["total"]); ?> +'</p>');
		}
	    });
	});
    });
</script>

<div class="table-responsive">
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Coverage Name</th>
			<th>Cost</th>
		</tr>
	</thead>
	<tbody>
<?php
	$className = "'confirmation'";
	foreach ($result as $row) {
?>
			<tr>
			<td><?php echo escape($row["id"]); ?></td>
			<td><?php echo escape($row["CoverageName"]); ?></td>
			<td><?php echo escape($row["Cost"]); ?></td>
			<td><?php echo "<a href=" . "update.php?id=" . $row["id"] . ">" . "Update</a>" ?> </td>
		    <td><?php echo "<a href=" . "delete.php?id=" . $row["id"] . " class=" . $className . "> Delete </a>" ?></td>
		</tr>
<?php
	}
?>
    </tbody>
</table>
</div>
</section>
<?php
// }

?>

<?php require "./public/templates/footer.php";?>