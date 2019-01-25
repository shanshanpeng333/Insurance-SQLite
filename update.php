<?php
require "./public/templates/header.php";

if (isset ( $_POST ['submit'] )) {
    try {		
        require "./config.php";
		require "./common.php";
		
		$oldCost= $_POST ['oldCost'];
		$oldCoverage=$_POST['oldCoverage'];        
        $coverageName = $_POST ['CoverageName'];
		$cost = $_POST ['Cost'];
        //reopeat validation
        try{
            $connection = new PDO ( $dsn );
		    $connection->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        
            $sql = "SELECT * FROM Coverage WHERE CoverageName=:CoverageName and Cost=:Cost";
            $statement = $connection->prepare ( $sql );
            $statement->bindParam ( ':CoverageName', $coverageName);
            $statement->bindParam ( ':Cost', $cost);
            $statement->execute ();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }

        if($result)
        {
            echo "<blockquote><p>This coverage is already exist. Please choose another one.</p></blockquote>";
            echo "</br><blockquote><a href='index.php'>Back to home</a></blockquote>";
        }
        else
        { 
		  if($cost > 0)
		  {
			if($coverageName==$oldCoverage)
			{
			     $sql = "UPDATE Coverage SET CoverageName=:CoverageName, Cost=:Cost WHERE id=:id";

			     $id = $_GET['id'];
			     $statement = $connection->prepare ( $sql );
			     $statement->bindParam ( ':CoverageName', $coverageName);
			     $statement->bindParam ( ':Cost', $cost);
			     $statement->bindParam ( ':id', $id);
			     $statement->execute ();
                
			     echo "<blockquote><p>The Insurance Type " . $coverageName . " cost was updated from $".$oldCost." to $".$cost." successfully!</p></blockquote>";
                 echo "</br><blockquote><a href='index.php'>Back to home</a></blockquote>";
			
			     $to = "coverages@fredcohen.com";
			     $subject = "The Insurance Product ".$coverageName. " was updated ";
			     $message = "The Insurance Product ".$coverageName. " cost was updated from $".$oldCost. " to $".$cost;
			     $header = "From:db@gazdb.com \r\n";
			     $retval = mail($to, $subject, $message, $header);
			     if ($retval != true) {
				    echo "Message could not be sent...";
			     }
			}
			else{
				echo "<blockquote><p>Insurance type cannot be changed!</p></blockquote>";
                echo "</br><blockquote><a href='index.php'>Back to home</a></blockquote>";
			}			
		}
		else{
			echo "<blockquote><p>Updated Insurance Cost must be greater than zero!</p></blockquote>";
            echo "</br><blockquote><a href='index.php'>Back to home</a></blockquote>";
		}
	   } 
    }
    catch ( PDOException $error ) {
		echo $sql . "<br>" . $error->getMessage ();
    }	
    exit();
}
?>	

<?php
if (isset ( $_GET ['id'] )) {	
	try {	
        require "./config.php";
		require "./common.php";
		$connection = new PDO ( $dsn);		
		$sql = "SELECT * FROM Coverage WHERE id = :id";
		
		// $location = $_POST ['location'];
		$id = $_GET ['id'];
		
		$statement = $connection->prepare ( $sql );
		$statement->bindParam ( ':id', $id );
		$statement->execute ();
		
		$result = $statement->fetchAll ();
	} catch ( PDOException $error ) {
		echo $sql . "<br>" . $error->getMessage ();
	}
}
?>
	
<section>		
<?php
if ($result) {
	?>
<h2>Update a Insurance Product</h2>
<form method="post">
	<?php
	foreach ( $result as $row ) {
		?>	
	<input type="text" hidden name="oldCoverage" id="oldCoverage" value="<?php echo escape($row["CoverageName"]); ?>" readonly> 
	
	<label for="Coverage">Coverage</label>
	</br>
	<input type="text" name="CoverageName" id="Coverage" value="<?php echo escape($row["CoverageName"]); ?>"readonly> 
	</br>
	<label for="oldCost">Original Cost</label>
	</br>
	<input type="number_format" name="oldCost" id="oldCost" value="<?php echo escape($row["Cost"]); ?>" readonly>
	</br>
	<label for="Cost">New Cost</label>
	</br>
	<input type="number" name="Cost" id="Cost"  min="0" required> 
	</br>
	</br>
	<input type="submit"  name="submit" value="Update">
	</br>
</form>
<?php
	}
	?>
<?php
} else {
	?>
    <blockquote>No results found for <?php echo escape($_GET['id']); ?>.</blockquote>
<?php
}
?>
</br>
<blockquote><a href="index.php">Back to home</a></blockquote></br>
</section>



<?php require "./public/templates/footer.php"; ?>