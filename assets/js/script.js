$(document).ready(function(){
    $("#submit").click(function(){
        var name = $("#name").val();
        var comment = $("#commentData").val();
        // Returns successful data submission message when the entered information is stored in database.
        var dataString = 'name1='+ name + '&comment1='+ comment;
        if(name===''||comment==='')
        {
            alert("Please Fill All Fields");
        }
        else
        {
        // AJAX Code To Submit Form.
            $.ajax({
                type: "POST",
                url: "art.php",
                data: dataString,
                success: function(){
                    //location.reload();
                    //$('#output').html();
                }
            });
        }
        return false;
    });
});

