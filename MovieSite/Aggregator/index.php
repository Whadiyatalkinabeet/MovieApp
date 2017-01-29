<html>
<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	session_start();
	if (!isset($_SESSION['newusername'])){
		header("location:../LogIn/CWlogin.html");
	} 
?>
	<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> 
	<script src="https://use.fontawesome.com/315005207c.js"></script>
		 <!--<script type="text/javascript">
	            $(document).ready(function(){
	                 $("#NewReleases").click(function(){
	                    $("#main").load("NewReleases.html");
	                 });
	            });
	        </script>-->
		<meta name="viewport" content="width=device-width", initial-scale="1">
		
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
		<title>Portal: Aggregator by Jonathan Mendoza</title>
	</head>
	<body>
		<ul>
		  <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
		  <li><a href="#about">About </a></li>
		  <li><a href="#about">Library</a></li>
		  <li><a href="#myaccount">My Account</a></li>
		  <li><a href="../LogIn/logout.php">Log Out</a></li>
		</ul>
		<div class="intro">
		<h1><i class="fa fa-film"></i> The Movie Portal  </h1>
		<h2>Your one-stop portal for all your movie needs.</h2>
		<?php
			echo "<h2>Welcome " . $_SESSION['newusername'] . "</h2>";
		?>
		</div>

		<div id="main" class="linklist">
			<a href="javascript:void()" class ="falselink" id="NewReleases" onclick="NewReleases()"><h2><i class="fa fa-newspaper-o" aria-hidden="true"></i> Keep up with the movie scene</h2></a>
			<a href="javascript:void()" class="falselink" id="featured" onclick="TopRated()"><h2><i class="fa fa-heart" aria-hidden="true"></i> Top Movies</h2></a>
			<a href="javascript:void()" class="falselink" onclick="ShowForm()"><h2><i class="fa fa-search" aria-hidden="true"></i> Find a Movie</h2></a>
			<div class="hidden" id="ByTitle">
				<h3>Enter movie title below</h3>
				<form action="FindMovie.php" type="get">
				<input type="text" required="required" name="movieTitle" placeholder="Home Alone">
				<input type="submit" value="Submit">
				</form>
			</div>
		</div>
	</body>
	<script>
		function NewReleases(){
			var url = "https://api.themoviedb.org/3/discover/movie?api_key=6d64a72486b47e66eaf157cafc5a0860&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1";
			var From="NewReleases";
			window.history.pushState(null,null,'NewReleases');//Mostly for future extensibility 
			$.getJSON(url, function(result){
				var titleList = '<h3>Here are the most talked about movies of recent times.</h3><h4>Taken from TMDB\'s daily updated list.</h4>';
				for(count=0; count<20; count++){
					var title=result.results[count].title;
					titleList = titleList + '<a href="javascript:void()" class="falselink" id="NewReleases" name="'+ title +'" onclick="MovieInfo(this.name,this.id)">' + title + '</a>' + '<br>';
				}
					titleList += '<br><h3><a href="index.html"> Back Home </a></h3>';
				document.getElementById("main").innerHTML=titleList;

		    });
		}
		
		function TopRated(){
			var url = "https://api.themoviedb.org/3/movie/top_rated?api_key=6d64a72486b47e66eaf157cafc5a0860&language=en-US&page=1";
			var From="TopRated";
			window.history.pushState(null,null,'TopRated');//Mostly for future extensibility 
			$.getJSON(url, function(result){
				var titleList = '<h3>Here are the top rated movies according to TMDB users</h3>';
				for(count=0; count<20; count++){
					var title=result.results[count].title;
					titleList = titleList + '<a href="javascript:void()" class="falselink" id="TopRated" name="'+ title +'" onclick="MovieInfo(this.name,this.id)">' + title + '</a>' + '<br>';
				}
				titleList += '<br><h3><a href="index.html"> Back Home </a></h3>';
				document.getElementById("main").innerHTML=titleList;
        		//alert(result.results[0].title);
		    });
		}

		function MovieInfo(thisname,mystatus){
			var movieName=thisname;
			var from = mystatus;
			var url = "https://api.themoviedb.org/3/search/movie?api_key=6d64a72486b47e66eaf157cafc5a0860&query="+movieName;
			window.history.pushState(null,null,movieName);//Mostly for future extensibility 
			$.getJSON(url, function(result){
				var posterURL = "http://image.tmdb.org/t/p/w185" + result.results[0].poster_path;
				var plot = result.results[0].overview;
				var date = result.results[0].release_date;
				var rating = result.results[0].vote_average;
				var HTML=MovieInfoHTML(from,movieName,posterURL,plot,date,rating);
				document.getElementById("main").innerHTML=HTML;
			});
		}
		function MovieInfoHTML(mystatus,title,poster,plot,date,rating){
			//alert(mystatus);
			if(mystatus == 'NewReleases'){
				return '<h3>' + title + '</h3>' + 
				   '<img src="'+ poster + '">' + '<br> <br>' +
				   plot + '<br>' + '<br>'+ 
				   'Date released: ' + date + '<br>' +
				   'Average rating: ' + rating + '<br> <div onclick="MovieReview(this.id)" id="'+ title +'"> <a href="javascript:void()" class="falselink">Get NYT Review and Alternate Summary</a></div>'+ '<br><br>' +
				    '<h4><a href="#" onclick="NewReleases()">Back to the list</a></h4>';
			}
			if (mystatus=='TopRated'){
				return '<h3>' + title + '</h3>' + 
				   '<img src="'+ poster + '">' + '<br> <br>' +
				   plot + '<br>' + '<br>'+ 
				   'Date released: ' + date + '<br>' +
				   'Average rating: ' + rating + '<br> <div onclick="MovieReview(this.id)" id="'+ title +'"> <a href="javascript:void()" class="falselink">Get NYT Review and Alternate Summary</a></div>'+ '<br><br>' +
				    '<a href="#" onclick="TopRated()"><h4>Back to the list</h4></a>';
			}
			else{
				return '<h3>' + title + '</h3>' + 
				   '<img src="'+ poster + '">' + '<br> <br>' +
				   plot + '<br>' + '<br>'+ 
				   'Date released: ' + date + '<br>' +
				   'Average rating: ' + rating + '<br> <div onclick="MovieReview(this.id)" id="'+ title +'"> <a href="javascript:void()" class="falselink">Get NYT Review and Alternate Summary</a></div>'+ '<br><br>' +
				    '<a href="index.html"><h4>Back Home</h4></a>';
			}
		}
		function MovieReview(movieTitle){
			var url = "https://api.nytimes.com/svc/movies/v2/reviews/search.json?&api-key=819eb6ca6a8f444eb41be81cd61cbeea&query='" + movieTitle + "'";
			$.getJSON(url, function(result){
				if(result.num_results == 0){
					document.getElementById(movieTitle).innerHTML="Movie data not found on NYT API"; //error handling
				}
				else{
				var reviewURL = result.results[0].link.url;
		        var reviewTitle = result.results[0].headline;
		        var reviewDate = result.results[0].publication_date;
		        var author = result.results[0].byline;
		        var shortSummary =result.results[0].summary_short;
		        var HTML = MovieReviewHTML(reviewURL,reviewTitle,reviewDate,author,shortSummary);
		        //alert(reviewURL);
				document.getElementById(movieTitle).innerHTML=HTML; 
				}
		        
				
			})
			.error(function(){alert("error");});
		}
		function ShowForm()
		{
		    document.getElementById("ByTitle").style.display="block";
		}
		$(function () {

	        $('form').on('submit', function (e) {

	          e.preventDefault();

	          $.ajax({
	            type: 'get',
	            url: 'FindMovie.php',
	            data: $('form').serialize(),
	            success: function(result){

							SearchMovie(result);
						}
	          });

	        });

	    });

	    function SearchMovie(link){
	    	var URL = link;
	    	window.history.pushState(null,null,'Search Results');//Mostly for future extensibility 
	    	$.getJSON(URL, function(result){
				var titleList = '<h3>Search Results</h3> <br>';
				for (var key in result.results){
					var title = result.results[key].title;
					titleList = titleList + '<a href="#" class="falselink" class="SearchMovie" name="'+ title +'" onclick="MovieInfo(this.name,this.class)">' + title + '</a>' + '<br>';
				}
				titleList += '<br><h3><a href="index.html"> Back Home </a></h3>';
				document.getElementById("main").innerHTML=titleList;
		    });
	}
		function MovieReviewHTML(url,title,date,author,summary){
			return '<br> <a href="'+url+'" ><strong> Read NY Times\'"' +title+'"</strong><br> by: ' + author + '</a> <br><br> <strong>New York Times\' short summary </strong><br><br>' + summary ;
		}

	</script>
		
This website is powered by <a href="https://www.themoviedb.org/documentation/api">TMDB API</a> and the <a href="https://developer.nytimes.com/"> New York Times API. </a><br> Made by Jonathan Mendoza.
</html>
