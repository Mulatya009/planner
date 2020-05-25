//VARIABLES
const helpBtn = document.querySelector('#help-btn');
const helpMessage = document.querySelector('#help-message');


//EVENT LISTENERS
loadEventListeners();

function loadEventListeners(){
    helpBtn.addEventListener('click', displayHelp);
}

//FUNCTIONS
function displayHelp(e){
    helpMessage.innerHTML = "To reset your password, enter either User Name or your Email. select your security question followed by the answer then enter your new password and confirm the new password";
}






