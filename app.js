function validateForm() {
    //Validates inputfields via frontend 
    const username = document.forms["signUpForm"]["email"].value;
    const password = document.forms["signUpForm"]["password"].value;

    // if the input field is empty then prompt the message Email must be filled
    if ( username == ""){
        console.log("Email must be filled out");
        return false;
    }
    // if the password input field is empty then prompt the message Password must be filled
    if ( password == "" ){
        console.log("Password must be filled out");
        return false;
    }
}

function showPage(pageId) {
    console.log('showing page....', pageId )
    
    document.querySelectorAll('.subpage').forEach(item => {
        item.style.display = "none";
    })
    document.getElementById(pageId).style.display = "grid";
}



var modal = document.getElementById("myModal");

var btn = document.getElementById("myBtn");

// Get the button that opens the modal
btn.onclick = function () {
    modal.style.display = "block";
}

//When the user clicks anywhere outside the modal, close it
window.addEventListener("click", function(event){
    if (event.target == modal){
        modal.style.display = "none";
    }
})

let logInBtn = document.querySelector("#logInBtn");

var logOutBtn = document.querySelector(".logout");

logOutBtn.onclick = function () {
    window.location.href = "logout.php";
}


function createTweet() {
    console.log("xxxxx")
    getTweets();
}


function tweet() {

    console.log("tweeting");
    getTweets();
}

var latestReceivedTweetId = 0; 

async function getTweets() {
    document.querySelector("#tweetsProfile").innerHTML = "";
    document.querySelector("#tweets").innerHTML = "";

    let request = await fetch('api-get-tweet.php');
    let sResponse = await request.text();
    let jResponse = JSON.parse(sResponse);
    //console.log(jResponse);

    let aUserTweets = jResponse;

    console.log(jResponse);

    let i; 
    for(i = 0; i < aUserTweets.length; i++){
        //console.log(aUserTweets[i]);
        //console.log(aUserTweets[i].id);
        //console.log(aUserTweets[i].author)
        
        let divTweet = ` 
            <div id="tweetWrapper" class="tweet">
            <p><strong>${aUserTweets[i].author}</strong> @${aUserTweets[i].author}</p>
            <p>${aUserTweets[i].message}</p>
            </div>`
        document.querySelector("#tweets").insertAdjacentHTML('afterbegin', divTweet);

        let divTweetProfile = `
            <div class="tweetProfile" id="${aUserTweets[i].id}">
            <p>${aUserTweets[i].message}</p>
            <button onclick='deleteTweet("${aUserTweets[i].id}")'>Delete</button>
            <button onclick='updateTweet("${aUserTweets[i].id}")'>Update</button>
            </div> 
            `
            document.querySelector("#tweetsProfile").insertAdjacentHTML('afterbegin', divTweetProfile);
    }
}

/*
setInterval(async function (){
    getTweets();
}, 5000);

*/

window.onload = function() {
    console.log('xxxx')
    getTweets();
}


function deleteTweet(tweetId) {
    console.log("Tweet delete clicked" + tweetId);
    window.location = "api-delete-tweet.php?tweetId=" + tweetId
}

function updateTweet(tweetId){

    console.log(tweetId);

    let modalUpdateForm = `
        <div id="modalFormContainer">
        <div class="modal-data">
        <form class="modal-data" action="api-update-tweet.php?tweetId=${tweetId}" method="POST">
        <div class="form-heading"><div class="x-btn red-btn"></div></div>
            <label>Update Tweet</label><input name="newTweetTitle" type="text" placeholder="Enter new Title" date-type="string">
            <button class="modal-btn" type="submit">UPDATE</button>
        </form>
        </div>
        </div>
    `
    document.querySelector('body').innerHTML += modalUpdateForm;

}


/*
var el = document.querySelector('.notification');

setInterval( function(){
    var count = Number(el.getAttribute('data-count')) || 0;
    el.setAttribute('data-count', count + 1);
    el.classList.remove('notify');
    el.offsetWidth = el.offsetWidth;
    el.classList.add('notify');
    if(count === 0){
        el.classList.add('show-count');
    }
}, 5000)

*/
