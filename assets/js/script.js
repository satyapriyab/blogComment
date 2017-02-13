
/*
* File    : script.js
* Purpose : Contains all jquery codes to have functionality
* Created : 08-feb-2017
* Author  : Satyapriya Baral
*/

$(document).ready(function(){
     
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
               $('#output').show();
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
               $('#articleData').html('Please Enter Searching Keyword');
          } else {
               $.post('search.php', { articleData: articleData }, function(data) {
                    $('#articleData').html(data);
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
               var category;
               if (selected === 'All') { category = 'All';}
               else if (selected === 'Sports') { category = 'Sports';}
               else if (selected === 'Politics') { category = 'Politics';}
               else if (selected === 'Education') { category = 'Education';}
               window.location.href = "http://localhost/fm/index.php?pageId=0&category="+category;
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
     
     function checkContent(){
          var content = $("#content").val().length;
          if(content < 1)  
          {
               $("#content-error").html("Please Enter Blog Content");
               $("#content-error").show();
               errorContent = true;
          }
          else
          {
               $("#content-error").hide();
          }
    
     }
     $("#blog-submit").on('submit' , function(e){
        e.preventDefault();
        
        errorTitle = false;
       // errorAuthor = false;
        //errorContent = false;
        
        checkTitle();
       // checkAuthor(); 
        //checkContent();
        
        if(errorTitle === false)
        {
               return true;
        }else{
               return false;
        }
    });
});