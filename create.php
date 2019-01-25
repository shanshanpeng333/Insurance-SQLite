<?php

require "./public/templates/header.php";
?>

<section>
<h2>Add New Insurance Product</h2>
<form id="createrecord" method="post">
	<label for="coverage">Type of Insurance Coverage</label> 
    </br>
	<select name="CoverageName" id="CoverageName" size="1">
		<option value="AUTO">Auto Insurance</option>
		<option value="PROPERTY">Property Insurance</option>
		<option value="LEGAL EXPENSE">Legal Expense</option>
	</select>
    </br>
	<label for="cost">Insurance Cost</label>
	</br>
	<input type="number" name="Cost" id="Cost" min="0" autofocus required> 
	</br>
	</br>
	<input type="submit" name="submit" value="Submit">
	</br>
</form>
</div>
</br>
<a href="index.php">Back to home</a>
</section>

 <?php       
if (isset ( $_POST ['submit'] )) {
	
	require "./config.php";
	require "./common.php";
	
	$cost=$_POST['Cost'];//Cost is the name in DB 
	$coverageName=$_POST['CoverageName'];
    
    //repeat validation
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
    catch(PDOException $error){
        echo $sql . "<br>" . $error->getMessage();
    }

    if($result)
    {
        echo "<blockquote><p>This coverage is already exist!</p></blockquote>";
    }
    else
    {        
	   if($cost>0)
	   {
		if($coverageName==('AUTO') || $coverageName==('PROPERTY') || $coverageName==('LEGAL EXPENSE'))
		{
			try {
			// $connection = new PDO ( $dsn, $username, $password, $options );
                $connection = new PDO ( $dsn );
                $connection->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );	
                $sql = "INSERT INTO Coverage(CoverageName, Cost) VALUES(:CoverageName, :Cost)";
                $statement = $connection->prepare ( $sql );
                $statement->bindParam ( ':CoverageName', $coverageName);
                $statement->bindParam ( ':Cost', $cost);
                $statement->execute ();
            
                echo "<blockquote><p>The Insurance Type " . $coverageName . " with cost $".$cost." was created successfully!</p><blockquote>";
                
                //Send the email 
                $to = "coverages@fredcohen.com";
		        $subject = "New " . $coverageName. " insurance product added";
		        $message = "A new ".$coverageName." insurance product was added with a cost of $".$cost;
		        $header = "From:db@gazdb.com \r\n";
		        $retval = mail($to, $subject, $message, $header);
		        if ($retval != true) {
			         echo "Message could not be sent...";
		        } 
            }
            catch ( PDOException $error ) {
                echo "<h1>Error Creating New Coverage: </br></h1>";
                echo $sql . "<br>" . $error->getMessage ();
                exit ();
			}
        }
        else{
				echo "<blockquote><p>Coverage must be of type AUTO, PROPERTY, or LEGAL EXPENSE!</p></blockquote>";
			}
        }
	   else
		{
		echo "<blockquote><p>Coverage must have a cost greater than zero</p></blockquote>";
		}
    }   
}
?>

