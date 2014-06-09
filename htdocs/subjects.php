<?php
// värden för pdo
$host     = "localhost";
$dbname   = "slutprojekt";
$username = "slutprojekt";
$password = "mkq5ik";

// skapa pdo
$dsn 	= "mysql:host=$host;dbname=$dbname";
$attr 	= array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

$pdo  	= new PDO($dsn, $username, $password, $attr);


if($pdo)
{
	//hämta data från form och spara i db (kod längst upp)
	if (!empty($_POST))
	{
		$_POST = null;
		$title = filter_input(INPUT_POST, 'title');
		// echo $name; 
		$statement = $pdo->prepare("INSERT INTO subjects (title) VALUES (:title)");
		$statement->bindParam(":title", $title);
		$statement->execute();
	}

	//visa formulär
	//matcha formulär med kolumner i tabell
	
	// visa all data ifrån tabell

}
?>
