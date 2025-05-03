const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('signIn');
const signUpForm=document.getElementById('signUp');

signUpButton.addEventListener('click', function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";

})

signInButton.addEventListener('click', function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
})

function togglePassword() {
    var passwordField = document.getElementById("password");
    var checkbox = document.getElementById("showPassword");
    if (checkbox.checked) {
        passwordField.type = "text";  
    } else {
        passwordField.type = "password"; 
    }
}