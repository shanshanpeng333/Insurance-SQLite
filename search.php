<?php
if (isset($_POST['submit'])) 
{	
	try 
	{		
		require "./config.php";
		require "./common.php";
        
		$connection = new PDO ( $dsn );
		$sql = "SELECT * 
						FROM Coverage
						WHERE CoverageName = :CoverageName
						ORDER BY Cost ASC";

		$CoverageName = $_POST['CoverageName'];
		$statement = $connection->prepare($sql);
		$statement->bindParam(':CoverageName', $CoverageName, PDO::PARAM_STR);
		$statement->execute();
		$result = $statement->fetchAll();
	}	
	catch(PDOException $error) 
	{
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>
<?php require "./public/templates/header.php"; ?>
<section>
<h2>Search for Coverage by Type</h2>

<form method="post">
	<label for="coverage">Type of Insurance Coverage</label> 
    <br>
	<br>
	<select name="CoverageName" id="CoverageName" size="1">
		<option value="AUTO">Auto Insurance</option>
		<option value="PROPERTY">Property Insurance</option>
		<option value="LEGAL EXPENSE">Legal Expense</option>
	</select>
    
	<input type="submit" id="view" name="submit" value="View Results">
	<br><br>
</form>	
	
<?php  
if (isset($_POST['submit'])) 
{
	if ($result) 
	{ ?>

		<h2>Results</h2>
		<div class="table-responsive">
			<table class="table table-striped"> 
				<thead>
					<tr>
						<th>#</th>
						<th>Coverage Type</th>
						<th>Cost</th>
					</tr>
				</thead>
			<tbody>
	<?php 
		foreach ($result as $row) 
		{ ?>
			<tr>
				<td><?php echo escape($row["id"]); ?></td>
				<td><?php echo escape($row["CoverageName"]); ?></td>
				<td><?php echo escape($row["Cost"]); ?></td>
			</tr>
		<?php 
		} ?>
		</tbody>
	</table>
	<a href="index.php">Back to home</a><br>
	</div>
	</section>
	<?php 
	} 
	else 
	{ ?>
		<blockquote>No results found for <?php echo escape($_POST['CoverageName']); ?>.</blockquote>
	<?php
	} 
}?> 

<?php require "./public/templates/footer.php"; ?>