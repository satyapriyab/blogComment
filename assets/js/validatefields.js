/*
* File    : form_jquery.js
* Purpose : Contains all functions for User Registration Form Validation, table creation and update
* Created : 11-jan-2017
* Author  : Satyapriya Baral
*/

$(function() {
    $("#nameErrorMessage").hide();
    $("#passwordErrorMessage").hide();
    $("#confirmPasswordErrorMessage").hide();
    $("#emailErrorMessage").hide();
    
    var errorName = false;
    var errorPassword = false;
    var errorConfirmPassword = false;
    var errorEmail = false;
    
    $("#name").focusout(function(){
        checkName();
    });
    
    $("#password").focusout(function(){
        checkPassword();
    });
    
    $("#confirm-password").focusout(function(){
        checkPassword();
    });
    
    $("#email").focusout(function(){
        checkEmail();
    });
    
    /*
    * Function for Username Validation.
    * Takes id of name as input.
    */
    function checkName(){
        var nameLength = $("#name").val().length;
        if(nameLength < 5 || nameLength > 30)
        {
            $("#nameErrorMessage").html("should be between 5-30 charecters");
            $("#nameErrorMessage").show();
            errorName = true;
        }
        else
        {
            $("#nameErrorMessage").hide();
        }
    }
    
    /*
    * Function for Password Validation.
    * Take id of password field as input.
    */
    function checkPassword(){
        var password = $("#password").val();
        var confirmPassword = $("#confirm-password").val();
        if( password != confirmPassword )
        {
            $("#passwordErrorMessage").html("Password Mismatch");
            $("#passwordErrorMessage").show();
            $("#confirmPasswordErrorMessage").html("Password Mismatch");
            $("#confirmPasswordErrorMessage").show();
            errorPassword = true;
            errorConfirmPassword = false;
        }
        else if( password.length < 5 || confirmPassword.length < 5 )
        {
            $("#passwordErrorMessage").html("Should be minimum of 5 charecters");
            $("#passwordErrorMessage").show();
            $("#confirmPasswordErrorMessage").html("Should be minimum of 5 charecters");
            $("#confirmPasswordErrorMessage").show();
            errorPassword = true;
            errorConfirmPassword = false;
        }
        else
        {
            $("#passwordErrorMessage").hide();
            $("#confirmPasswordErrorMessage").hide();
        }
    }

    /*
    * Function for Email Validation.
    * Takes id of Email field as input.
    */
    function checkEmail(){
        var email = $("#email").val();
        var at_pos = email.indexOf("@");
        var dot_pos = email.lastIndexOf(".");
        if ( at_pos < 1 || dot_pos < at_pos+2 || dot_pos+2 >= email.length ) {
            $("#emailErrorMessage").html("Incorrect Mail");
            $("#emailErrorMessage").show();
            errorEmail = true;
        }
        else
        {
            $("#emailErrorMessage").hide();
        }
    }
    
    /*
    * Submit Button Function.
    * Submits the form and deletes the row in the table that will be updated.
    */
    $("#register-form").on('submit' , function(){
        
        errorName = false;
        errorPassword = false;
        errorEmail = false;
        
        checkName();
        checkPassword(); 
        checkEmail();

        if(errorName === false && errorPassword === false && errorEmail === false)
        {
            return true;
        }else{
            return false;
        }
    });
});