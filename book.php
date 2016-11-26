<html lang="en">

	<head>

		<title>Democratic Book Review</title>
		
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link href="term_project.css" type="text/css" rel="stylesheet">
	</head>

	<body background="galaxy.jpg">
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.html">Democratic Book Review</a>
				</div>
				<form action="genreSearch.php" method="post">
					<ul class="nav navbar-nav">
						<li id="ali"><button type="submit" name="submit" value="all" class="btn btn-link" id="abc">Alphabetical Listing</button></li>
						<li class="dropdown"><a class="dropdown-toggle" style="text-decoration: none; background-color: transparent" data-toggle="dropdown" href="#">By Genre<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><button type="submit" name="submit" value="sc%f%" class="btn btn-link">All Science Fiction</button></li><br/>
								<li><button type="submit" name="submit" value="%fantasy%" class="btn btn-link">All Fantasy</button></li> <br/>
								<li><button type="submit" name="submit" value="%adventure%/%action%"class="btn btn-link" >Adventure</button></li><br/>	
								<li><button type="submit" name="submit" value="%alien%" class="btn btn-link">Aliens</button></li><br/> 					
								<li><button type="submit" name="submit" value="%alt%hist%/%steampunk%" class="btn btn-link">Alternative History/Steampunk</button></li><br/> 
								<li><button type="submit" name="submit" value="%angel%/%demon%" class="btn btn-link">Angels and Demons</button></li><br/> 
								<li><button type="submit" name="submit" value="%apocalyp%/%d%stopia%" class="btn btn-link">Apocalypse/Dystopia</button></li><br/>
								<li><button type="submit" name="submit" value="%crime%/%mystery%/%detective%" class="btn btn-link">Crime</button></li><br/>
								<li><button type="submit" name="submit" value="%dark%fantasy%" class="btn btn-link">Dark Fantasy</button></li><br/>
								<li><button type="submit" name="submit" value="%horror%/%creepy%" class="btn btn-link">Horror</button></li><br/>
								<li><button type="submit" name="submit" value="%hum%r%/%comedy%/" class="btn btn-link">Humor</button></li><br/>
								<li><button type="submit" name="submit" value="%magic%" class="btn btn-link">Magic</button></li><br/>
								<li><button type="submit" name="submit" value="%military%/%espionage%/%spy%/%assassin%" class="btn btn-link">Military/Espionage</button></li><br/>
								<li><button type="submit" name="submit" value="%roman%/love/%erotic%" class="btn btn-link">Romance</button></li><br/>	
							</ul>
						</li>
						<li><a href="about.html">About</a></li>
						<li><a href="feedback.html">Feedback</a></li>
					</ul>
				</form>
				<form class="navbar-form navbar-right" action="search.php" method="post">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search" name="search">
						<div class="input-group-btn">
							<button class="btn btn-default" type="submit">
								<i class="glyphicon glyphicon-search"></i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</nav>

		<?php

			$title = $_POST['submit'];
			
			$servername = 'localhost';
			$username = 'root';
			$password = 'root';
			$database = 'books';
			
			// Create connection
			$mysqli = new mysqli($servername, $username, $password, $database);
					
			if ($mysqli->connect_errno) {
				echo('could not connect to database');
			}//if

			$query = "SELECT * from book WHERE Title='" . $title . "'";
			
			$result = $mysqli->query($query);
			
			$book = $result->fetch_assoc(); 
			echo "<h3>" . $book['Title'] . "-" . $book['Author'] . "</h3>";
			echo "<p id='id' value='" . $book['Id'] . "'>". $book['Id'] . "</p>";
			
			$query = "SELECT * from keyword WHERE Bookid = " . $book['Id'];

			$wordArray = [];
	
			$result = $mysqli->query($query);
	
			$i = 0;
	
			if($result->num_rows > 0){
		
				while ($word = $result->fetch_assoc()) {
			
					$wordArray[$i] = [$word['Word'], (string)$word['Num']];
					$i++;
				}
			} 
			
			
			$author = $book['Author'];
			$publicationDay = $book['PublicationDay'];
			$publicationMonth = $book['PublicationMonth'];
			$publicationYear = $book['PublicationYear'];
			$cover = $book['Cover'];
			$id = $book['Id'];
			$numStars = $book['NumStars'];
			$sentimentScore = $book['SentimentScore'];
			$angerScore = $book['AngerScore'];
			$fearScore = $book['FearScore'];
			$joyScore = $book['JoyScore'];
			$sadnessScore = $book['SadnessScore'];
			$disgustScore = $book['DisgustScore'];

			$result->free();
			$mysqli->close();
		?>
		<canvas id='my_canvas' height='400' width='400'></canvas>
		<script src="wordcloud2.js"></script>
		<script>
			var data = <?php echo json_encode($wordArray)?>;
			
			var options = {
				list : data, 
				weightFactor: 2, 
				rotateRatio: .5,
				backgroundColor: "#0000ffff"
			}//options
			
			WordCloud(document.getElementById('my_canvas'), options);
		</script>
	</body>
</html>