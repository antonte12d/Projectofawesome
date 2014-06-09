<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Elevhjälpen - av elever för elever!</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>

<body>

	<header>
		<a href="index.php"><img src="logo.png" id="logotype"></a>
		<div id="headerContent">
			<h1 id="headline">Välkommen till Elevhjälpen!</h1>

			<nav id="menu">
				<ul>
					<li class="menuButton" id="homeButton"><a href="index.php" method="post">HEM</a></li>
					<li class="menuButton" id="summariesButton"><a href="summaries.php" method="post">SAMMANFATTNINGAR</a></li>
					<li class="menuButton" id="addButton"><a href="add_summaries.php" method="post">LÄGG TILL</a></li>
					<li class="menuButton" id="aboutButton"><a href="about.php" method="post">OM OSS</a></li>
				</ul>
			</nav>
		</div>
	</header>
<div id="layout">
	<div id="coursesCell">
		<nav id="courses">
			<h1 id="coursesTitle">Kurser:</h1>
			<ul>
<?php
// värden för pdo
$host     = "localhost";
$dbname   = "slutprojekt";
$username = "slutprojekt";
$password = "mkq5ik";

// skapa pdo
$dsn 	= "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$attr 	= array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

$pdo  	= new PDO($dsn, $username, $password, $attr);

foreach($pdo->query("SELECT * FROM subjects ORDER BY name") as $row)
{
	echo "<li><a href=\"summaries.php?subject_id={$row['id']}\" class=\"courseLink\">{$row['name']}</a></li>";
}

?>

			</ul>
		</nav>
	</div>	
	<div id="contentCell">
		<section id="content">

			<?php

			if($pdo)
			{
				//hämta data från form och spara i db
				if (!empty($_POST))
				{
					if ($_POST['title'] && $_POST['content'] !== "") 
					{	
						$_POST = null;
						$title = filter_input(INPUT_POST, 'title');
						$subject_id = filter_input(INPUT_POST, 'subject_id');
						$content = filter_input(INPUT_POST, 'content');
						$user_id = filter_input(INPUT_POST, 'user_id');
						$statement = $pdo->prepare("INSERT INTO summaries (title, date, content, subject_id, user_id) VALUES (:title, NOW(), :content, :subject_id, :user_id)");
						$statement->bindParam(":title", $title);
						$statement->bindParam(":subject_id", $subject_id);
						$statement->bindParam(":content", $content);
						$statement->bindParam(":user_id", $user_id);
						if($statement->execute())
						{
							echo "<script>location.replace(\"summaries.php\");</script>";						}
						else
						{
							// Det fungerade inte
							print_r($statement->errorInfo());
						}
					}
				}

				//visa formulär
				//matcha formulär med kolumner i tabell
			?>
				<div id="addSummary">

					<form action="add_summaries.php" method="POST">
						<p>
							<label for="user_id">Användare: </label>
							<select name="user_id">
								<option selected disabled>Välj användare:</option>
								<?php 
									foreach ($pdo->query("SELECT * FROM users ORDER BY fname") as $row) {
										echo "<option value=\"{$row['id']}\">{$row['fname']} {$row['lname']}</option>";
									}
								?>
							</select>
						</p>

						<p>
							<label for="subject_id">Ämne: </label>
							<select name="subject_id">
								<option selected disabled>Välj ämne:</option>
								<?php 
									// 
									foreach ($pdo->query("SELECT * FROM subjects ORDER BY name") as $row) {
										echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
									}
								?>
							</select>
						</p>

						<p>
							<label for="title">Titel: </label>
							<input type="text" name="title" />
						</p>

						<p>
							<label for="content">Sammanfattning: </label>
							<textarea name="content"></textarea>
						</p>

						<p>
							<input type="submit" value="Lägg till" />
						</p>
					</form>
				</div>
			<?php	

				}
				else
				{
					// skriv ut felmeddelanden
					print_r($pdo->errorInfo());
				}
			?>
		</section>
	</div>
	<div id="usersCell">
		<section id="users">
			<h1><a href="add_users.php" id="registerLink">Registrera dig!</a></h1>
			<h2 id="usersTitle">Användare:</h2>
			<ul>

<?php 
foreach($pdo->query("SELECT * FROM users ORDER BY fname") as $row)
{
	echo "<li><a href=\"summaries.php?user_id={$row['id']}\" class=\"userLink\">{$row['fname']} {$row['lname']}</a></li>";
}
?>
			</ul>
		</section>
	</div>
</div>

	<footer id="bodyFooter">
		<p id="copyright">
			&copy; 2014 Anton Pettersson. All rights reserved.
		</p>
	</footer>

</body>
</html>