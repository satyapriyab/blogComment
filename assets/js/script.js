
/*
* File    : script.js
* Purpose : Contains all jquery codes to have functionality
* Created : 08-feb-2017
* Author  : Satyapriya Baral
*/

$(document).ready(function(){
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
            $.post('commentDisplay.php', { commentName: articleName , commentComment: articleComment}, function() {
                //$('#output').html(data);
                 location.reload();
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
        var articleName = $('#article-name').val();
        if($.trim(articleName) === '')
        {
            $('#articleData').html('Please Enter Searching Keyword');
        } else {
            $.post('search.php', { articleName: articleName }, function(data) {
                $('#articleData').html(data);
            });
        }
    });
});
  /**
  * Function to search data by Category.
  *
  * @param Null
  * @return Null
  */
$(document).ready(function() {
    $("#selectCategory").on("change",function(){
        var selected = this.value;
            var category;
            if (selected === 'All') { category = 'All';}
            else if (selected === 'Sports') { category = 'Sports';}
            else if (selected === 'Politics') { category = 'Politics';}
            else if (selected === 'Education') { category = 'Education';}
            window.location.href = "http://localhost/fm/index.php?pageId=0&category="+category;
    });
});