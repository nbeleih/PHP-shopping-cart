

function displayMovieInformation(movie_id)
{
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		document.getElementById("modalWindowContent").innerHTML = this.responseText;
		showModalWindow();
		};
	request.open("GET", "./movieinfo.php?movie_id=" + movie_id, true);
	request.send();
}

function forgotPassword()
{
	window.location.replace("./logon.php?action=forgot");
}

function showModalWindow()
{
    var modal = document.getElementById('modalWindow');
    var span = document.getElementsByClassName("_close")[0];

    span.onclick = function() 
    { 
        modal.style.display = "none";
    }

    window.onclick = function(event) 
    {
        if (event.target == modal) 
        {
            modal.style.display = "none";
        }
    }
 
    modal.style.display = "block";
}



function addMovie(imdbID)
{

    window.location.replace("./index.php?action=add&imdb_id=" + imdbID);
	
}

function confirmCancel()
{
    let askUser = confirm("Do you wish to return to your shopping cart?");
	 
    if(askUser) {

        window.location.replace("./index.php");
    }

}

function confirmCheckout()
{
	let confirm1 = confirm("Do you wish to Checkout?");
	 
    if(confirm1) {

        window.location.replace("./index.php?action=checkout");
    }

}

function confirmLogout()
{
	let permission;
    permission = confirm("Do you wish to logout of your shopping cart?");
	 
    if(permission) {

        window.location.replace("./logon.php?action=logoff");
    }

}

function confirmRemove(title, movieID)
{
	
    let permission2 = confirm(`Do you wish to remove ${title} from your cart?`);

    if(permission2) {

        window.location.replace("./index.php?action=remove&movie_id=" + movieID);

    }

}