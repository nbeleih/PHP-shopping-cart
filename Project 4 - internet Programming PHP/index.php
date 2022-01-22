<?php

$EMAIL_ID = 545314318; // 9-digit integer value (i.e., 123456789)
$API_KEY = "11bba141"; // API key (string) provided by Open Movie DataBase (i.e., "ab123456")

session_start(); // Connect to the existing session

require_once '/home/common/php/dbInterface.php'; // Add database functionality
require_once '/home/common/php/mail.php'; // Add email functionality
require_once '/home/common/php/p4Functions.php'; // Add Project 4 base functions

processPageRequest(); // Call the processPageRequest() function


function addMovieToCart($imdbID)
{	
  $movieExist = null;

	if($imdbID != null) {

      $movieExist = movieExistsInDB($imdbID);      //movie exists? ALSO CHECK IF THE CORRECT ARGUMENTS IS BEING PASSSED
  
      if($movieExist == 0) {   //if movie doesn't exist, add it
  
      $result= file_get_contents('http://www.omdbapi.com/?apikey='.$GLOBALS['API_KEY'].'&i='.$imdbID.'&type=movie&r=json');
      $movieInfo = json_decode($result, true);
  
      $title =  $movieInfo['Title'];
      $year = $movieInfo['Year'];
      $rating = [];
      $rating = $movieInfo['Ratings'];
      $runtime = $movieInfo['Runtime'];
      $genre = $movieInfo['Genre'];
      $actors = $movieInfo['Actors'];
      $director = $movieInfo['Director'];
      $writer = $movieInfo['Writer'];
      $plot = $movieInfo['Plot'];
      $poster = $movieInfo['Poster'];
  
      $addMovie = addMovie($imdbID, $title, $year, $rating, $runtime, $genre, $actors, $director, $writer, $plot, $poster);   //imdbId value?
  
    }

  }
   else {

    echo 'wrong from index.php';
  }

  $userId = $_SESSION["userId"];
  $movieId = $movieExist;
  

  addMovieToShoppingCart($userId, $movieId);

  displayCart();

}

function displayCart()
{
	  $userId = $_SESSION["userId"];
    $movies = getMoviesInCart($userId);   //returns an array containing the IDs of movies in user's cart
    require_once './templates/cart_form.html';

}

function processPageRequest()
{
	
    if(!($_SESSION["displayName"])) {   //Test whether the user's Display Name value is stored in the session

        header("Location: logon.php");
    }

    if(!empty($_GET['action'])) { //isset($_GET['action'] && 

      if($_GET['action'] == 'add') {

        addMovieToCart($_GET['imdb_id']);
        header("Location: index.php");

      }
      else {
        removeMovieFromCart($_GET['movie_id']);
        header("Location: index.php");

      }
    }
     else {

      displayCart();
    }

}

function removeMovieFromCart($movieID)
{	
	
  $userId = $_SESSION["userId"];
  if(!removeMovieFromShoppingCart($userId,$movieID)) {

    echo '<p>Movie does not exist <p>';
  }
   else {

    header("Location: index.php");

  }

}

?>