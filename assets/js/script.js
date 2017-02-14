
/*
* File    : script.js
* Purpose : Contains all jquery codes to have functionality
* Created : 08-feb-2017
* Author  : Satyapriya Baral
*/

$(document).ready(function(){
     
     //errors are hidden and will show when error occurs.
     $("#author-error").hide();
     $("#title-error").hide();
     
     errorTitle = false;
     errorContent = false;
     
     $("#title").focusout(function(){
          checkTitle();
     });
     
     $("#content").focusout(function(){
          checkContent();
     });  
     /**
     * Ajax call to add data to database and retrive it.
     * @param Null
     * @return Null
     */
     $('.preload').hide();
     $("#submit").click(function(){
          var articleName = $("#name").val();
          var articleComment = $("#commentData").val();
          if(articleName===''||articleComment==='')
          {
              alert("Please Fill All Fields");
          }
          else
          {
               // AJAX Code To Submit Form.
               $.post('commentDisplay.php', { commentName: articleName , commentComment: articleComment}, function(data) {
               $('#commentSection').hide();
               $('.preload').show();
               $(".preload").fadeOut(2000);
               $('#output').html(data);
               });
          }
          return false;
     });
     
     /**
     * Ajax call to display article by its name
     *
     * @param Null
     * @return Null
     */
     $("#article-name").on("keyup",function(){
          var articleData = $('#article-name').val();
          if($.trim(articleData) === '')
          {
               $('#articleData').hide();
               $('#indexData').show();
              // $('#articleData').html('Please Enter Searching Keyword');
          } else {
               $.post('search.php', { articleData: articleData }, function(data) {
                    $('#indexData').hide();
                    $('#articleData').show();
                    $('#articleData').html(data);
                    $(".author:contains('"+articleData+"')").css("color", "blue");
               });
          }
     });

     /**
     * Function to search data by Category.
     *
     * @param Null
     * @return Null
     */
     $("#selectCategory").on("change",function(){
          var selected = this.value;
          window.location.href = "http://localhost/fm/index.php?pageId=0&category="+selected;
     });
     
     /**
     * Function to validate that the author name doesnot include any special charecters
     *
     * @param alphabet - Contains the alphabet that is pressed
     * @return boolian value for true or false
     */
     $("#author").keypress(function (alphabet){
          var code =alphabet.keyCode || alphabet.which;
          if((code<65 || code>90)&&(code<97 || code>122)&&code!=32&&code!=46)  
          {
               $("#author-error").html("Only alphabates are allowed");
               $("#author-error").show();
               return false;
          }
          else
          {
               $("#author-error").hide();
               return true;
          }
     });
     
     /**
     * Function to validate that title is entered or not
     *
     * @param null
     * @return boolian value for true or false
     */
     function checkTitle(){
          var title = $("#title").val().length;
          if(title < 1)  
          {
               $("#title-error").html("Please Enter Title");
               $("#title-error").show();
               errorTitle = true;
          }
          else
          {
               $("#title-error").hide();
          }
     }
     
     /**
     * Function to check after the submit button is clicked on add post.
     *
     * @param null
     * @return boolian value for true or false
     */
     $("#blog-submit").on('submit' , function(e){
        e.preventDefault();
        
        errorTitle = false;
        
        checkTitle();
        
        if(errorTitle === false)
        {
               return true;
        }else{
               return false;
        }
    });
});