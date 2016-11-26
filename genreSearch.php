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
							
			$genre = $_POST['submit'];		
			
			$servername = 'localhost';
			$username = 'root';
			$password = 'root';
			$database = 'books';

			$query = "";
			
			// Create connection
			$mysqli = new mysqli($servername, $username, $password, $database);
					
			if ($mysqli->connect_errno) {
				echo('could not connect to database');
			}//if
			
			if($genre == "all"){
				
				$query = "SELECT DISTINCT Title, Author, Cover, NumStars, SentimentScore FROM book GROUP BY Title";
			} else{
				
				$query = "SELECT DISTINCT Title, Author, Cover, NumStars, SentimentScore FROM book b, shelf s WHERE";
				
				$genre = explode('/', $genre);
					
				$i = 0;
					
				foreach($genre as $word){
					
					if($i > 0){
						$query .= " OR";
					}
					$query .= " s.Name LIKE '" . $word . "'";
					$i++;
				}

					$query .= " AND s.Bookid = b.Id GROUP BY s.Num";
			}//if			
			
			$result = $mysqli->query($query);
			
			if($result->num_rows > 0){
				
				echo '<h3>' . $result->num_rows . ' Results:</h3>';
				echo '<form action="book.php" method="post">';
				
				while ($book = $result->fetch_assoc()) {
					
					$title = $book['Title'];
					$author = $book['Author'];
					$cover = $book['Cover'];
					
					$numStars = $book['NumStars'];
					$roundStars = round($numStars);
					$starText = "";
					for($i = 0; $i < $roundStars; $i++){
						$starText .= "<span class='star'>&#x2605</span>";
					}
					for($i = 0; $i < (5-$roundStars); $i++){
						$starText .= "<span class='star'>&#x2606</span>";
					}
					
					$sentimentScore = $book['SentimentScore'] ;
					$sentimentText = round($sentimentScore * 100, 2);
					if($sentimentScore > 0){
						$sentimentText = '<span class=positive style="font-size: ' . ($sentimentText + 12) . 'px">' . $sentimentText . '% positive';
					} else{
						$sentimentText = '<span class=negative style="font-size: ' . (($sentimentText*(-1)) + 12) . 'px">' . ($sentimentText*(-1)) . '% negative';
					}
					
					echo  	'<div class="bookDiv"><button name="submit" class="searchBtn" type="submit" value="' . $title . '">' . 
							'<img class="coverImg" src=' . $cover . '></button><p class="bookP">' .
							'Title: ' . $title . '<br/>' . 
							'Author: ' . $author . '<br/>' . 
							'Rating: ' . $starText . '<br/>' . 
							'Score: ' . $sentimentText . '</p></div>';
							//'<hr class="featurette-divider">';
				}
				
				echo '</form>';
			} else{
				echo '<h3>No results found.</h3>';
			}
			
			$result->free();
			$mysqli->close();
		?>
	</body>
</html>