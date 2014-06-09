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

				$show_form = true;
				$fname = "";
				$lname = "";

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
						if($_POST['fname'] != "" && $_POST['lname'] != "")
						{
							$show_form = false;
							$_POST = null;
							$fname = filter_input(INPUT_POST, 'fname');
							$lname = filter_input(INPUT_POST, 'lname');
							$statement = $pdo->prepare("INSERT INTO users (fname, lname) VALUES (:fname, :lname)");
							$statement->bindParam(":fname", $fname);
							$statement->bindParam(":lname", $lname);
							if(!$statement->execute())
							{
								// Det fungerade inte
								print_r($statement->errorInfo());
							}
						}
						else
						{
							echo "<p class=\"response\">Fyll i både förnamn och efternamn!</p>";
						}
					}
				}
				if($show_form)
				{
				?>	
					<div id="addUser">
						<form action="add_users.php" method="POST">
							<p>
								<label for="fname">Förnamn: </label>
								<input type="text" name="fname" />
							</p>

							<p>
								<label for="lname">Efternamn: </label>
								<input type="text" name="lname" />
							</p>

							<p>
								<input type="submit" value="Registrera" />
							</p>
						</form>
					</div>
				<?php
				}
				else
				{
					echo "<p class=\"response\">Du är nu registrerad!</p>";
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