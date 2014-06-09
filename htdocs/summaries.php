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

				if(isset($_GET['subject_id']))
				{
					$subject_id = filter_input(INPUT_GET, "subject_id", FILTER_VALIDATE_INT);
				}
				else
				{
					$subject_id = 0;
				}

				if(isset($_GET['user_id']))
				{
					$user_id = filter_input(INPUT_GET, "user_id", FILTER_VALIDATE_INT);
				}
				else
				{
					$user_id = 0;
				}
				if(isset($_GET['summary_id']))
				{
					$summary_id = filter_input(INPUT_GET, "summary_id", FILTER_VALIDATE_INT);
				}
				else
				{
					$summary_id = 0;
				}
					
				if($summary_id != 0) 
				{
					// Visa detaljerad sammanfattning
					$summary_statement = $pdo->prepare("SELECT summaries.*, users.fname, users.lname, subjects.name FROM summaries INNER JOIN users ON summaries.user_id=users.id INNER JOIN subjects ON summaries.subject_id=subjects.id WHERE summaries.id=:summary_id ORDER BY date DESC");
					$summary_statement->bindParam(":summary_id", $summary_id);
					if($summary_statement->execute())
					{
						if($row = $summary_statement->fetch())
						{
							echo "<div id=\"summary_page\">
									<h2 id=\"summaryContentTitle\">{$row['title']}</h2>
									<div id=\"summaryInfo\">
										<p id=\"timeInfo\">{$row['date']}</p>
										<p>Kurs: <a href=\"summaries.php?subject_id={$row['subject_id']}\">{$row['name']}</a></p>
										<p>Av: <a href=\"summaries.php?user_id={$row['user_id']}\">{$row['fname']} {$row['lname']}</a></p>
									</div>
									<p id=\"summary_content\">{$row['content']}</p>
								</div>";

							// Visa kommentarer till sammanfattning
							echo "<div id=\"commentsCell\">";

							$comment_statement = $pdo->prepare("SELECT comments.*, users.fname, users.lname FROM comments INNER JOIN users ON comments.user_id=users.id WHERE summary_id=:summary_id ORDER BY date");
							$comment_statement->bindParam(":summary_id", $summary_id);
							if($comment_statement->execute())
							{
								while($comment = $comment_statement->fetch())
								{
									echo "<div class=\"comment\"><p class=\"commentInfo\"><a href=\"summaries.php?user_id={$comment['user_id']}\">{$comment['fname']} {$comment['lname']}</a> ({$comment['date']}):</p> <p class=\"commentContent\">{$comment['content']}</p></div>";
								}
							}
							else
							{
								print_r($comment_statement->errorInfo());
							}

							// Skriv kommentar till db
							if(!empty($_POST))
							{
								if ($_POST['user_id'] != "" && $_POST['content'] != "") 
								{
									$summary_id = filter_input(INPUT_POST, 'summary_id');
									$user_id = filter_input(INPUT_POST, 'user_id');
									$content = filter_input(INPUT_POST, 'content');
									$statement = $pdo->prepare("INSERT INTO comments (summary_id, user_id, date, content) VALUES (:summary_id, :user_id, NOW(), :content)");
									$statement->bindParam(":summary_id", $summary_id);
									$statement->bindParam(":user_id", $user_id);
									$statement->bindParam(":content", $content);
									if(!$statement->execute())
									{
										// Det fungerade inte
										print_r($statement->errorInfo());
									}
								}
							}
								echo "<form id=\"commentForm\" action=\"summaries.php?summary_id={$row['id']}\" method=\"POST\">";
								echo "<input type=\"hidden\" name=\"summary_id\" value=\"{$row['id']}\" />";
							?>
										<p>
											<label for="user_id"></label>
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
											<label for="content"></label>
											<input type="text" name="content" />
											<input type="submit" value="Kommentera" />
										</p>
									</form>
								</div>

							<?php 
						}
					}
					else 
					{
						print_r($summary_statement->errorInfo());
					}
				}

				else
				{
					// Visa sammanfattningar
					echo "<ul id=\"summaries\">";
					if($subject_id != 0){
						// Visa alla sammanfattningar av ett ämne
						$list_filter = "SELECT summaries.*, users.fname, users.lname, subjects.name FROM summaries INNER JOIN users ON summaries.user_id=users.id INNER JOIN subjects ON summaries.subject_id=subjects.id WHERE summaries.subject_id = $subject_id ORDER BY date DESC";
					}
					elseif($user_id != 0)
					{
						// Visa alla sammanfattningar av en användare
						$list_filter = "SELECT summaries.*, users.fname, users.lname, subjects.name FROM summaries INNER JOIN users ON summaries.user_id=users.id INNER JOIN subjects ON summaries.subject_id=subjects.id WHERE summaries.user_id = $user_id ORDER BY date DESC";
					}
					else
					{
						// Visa alla sammanfattningar
						$list_filter = "SELECT summaries.*, users.fname, users.lname, subjects.name FROM summaries INNER JOIN users ON summaries.user_id=users.id INNER JOIN subjects ON summaries.subject_id=subjects.id ORDER BY date DESC";
					}

					// Skriv ut sammanfattningar
					foreach($pdo->query($list_filter) as $row)
					{
						echo "<li class=\"summary\"><a href=\"summaries.php?summary_id={$row['id']}\">{$row['fname']} {$row['lname']}: {$row['name']} - {$row['title']}, ({$row['date']})</a></li>";
					}
					echo "</ul>";
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