<?php
require "./public/templates/header.php";
if (isset ( $_GET ['id'] )) {
	
	try {
		
		require "./config.php";
		require "./common.php";
		
		$connection = new PDO ( $dsn );
		$connection->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        
        $id = $_GET['id'];
		
        $sql = "SELECT CoverageName, Cost FROM Coverage WHERE id=:id";
		$statement = $connection->prepare ( $sql );
		$statement->bindParam ( ':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);        
        $cost= $result["Cost"];
        $coverageName= $result["CoverageName"];
		
		$sql = "DELETE FROM Coverage WHERE id=:id";
		$statement = $connection->prepare ( $sql );
		$statement->bindParam ( ':id', $id);
		$statement->execute ();	
	} catch ( PDOException $error ) {
		echo $sql . "<br>" . $error->getMessage ();
	}
	
	echo "<blockquote><p>The Insurance Type " . $coverageName . " cost ".$cost." was deleted successfully.</p></blockquote>";
    
	$to = "coverages@fredcohen.com";
    $subject = "The Insurance Product ".$coverageName. "was deleted ";
    $message = "The Insurance Product ".$coverageName. " of cost ".$cost." was deleted";
    $header = "From:db@gazdb.com \r\n";
    $retval = mail($to, $subject, $message, $header);
    if ($retval != true) {
        echo "<blockquote><p>Message could not be sent...</p></blockquote>";
    }	
}
?>
<br>
<blockquote><a href="index.php">Back to home</a></blockquote>