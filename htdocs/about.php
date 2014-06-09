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
			<div id="about">
				<h1 id="aboutTitle">Om oss: </h1>
				<p>
					Vi på Elevhjälpen har skapat möjligheten för elever i gymnasiet att på ett enklare sätt hjälpa varandra i pluggndet. Detta genom att skriva sammanfattningar till olika delmoment i olika kurser.
				</p>
				<p>
					Vi hoppas att du hittar mycket av det du söker på sidan till hjälp för dina studier.
				</p>
				<p>
					Med vänliga hälsningar Elevhjälpen.
				</p>
			</div>
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