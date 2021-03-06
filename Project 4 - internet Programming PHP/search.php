<?php

$API_KEY = "11bba141"; // API key (string) provided by Open Movie DataBase (i.e., "ab123456")

session_start(); // Connect to the existing session

processPageRequest();


function displaySearchForm()
{
	require_once('./templates/search_form.html');

}

function displaySearchResults($searchString)
{	
	$results = file_get_contents('http://www.omdbapi.com/?apikey='.$GLOBALS['API_KEY'].'&s='.urlencode($searchString).'&type=movie&r=json');
    $resultsArray = json_decode($results, true)["Search"];
    require_once('./templates/results_form.html');

}

function processPageRequest()
{
	if(!isset($_SESSION["displayName"])) {

        header("Location: login.php");
    } else {


        if(!empty($_POST) && $_POST['keyword']){

            $searchString = $_POST['keyword'];
            displaySearchResults($searchString);
        } 
        else {
            
            displaySearchForm();
            
        }
    }

}

?>