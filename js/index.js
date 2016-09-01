$(document).ready(function(){

    $(this).on("click", ".play_music", function(e){
        e.preventDefault();

        var music_name = $(this).attr("music-name");
        var path_file = $(this).attr("file-name");
 
 
        var data = {};
        data.path_file = path_file;
        $('.error').hide();
        $('.error').text("Now Playing: "+music_name);
        $('.error').fadeIn(400).delay(1000).fadeOut(400); //fade out after 3 seconds
        $.ajax({
            url: "API/api.php",
            data: data,
            type: "POST",
            dataType: "JSON",
            error: function(e){
                console.log(e);
            },
            success: function(result){
                console.log(result);
            }
        });


    });



    $(this).on("click", ".stop_music", function(e){
        e.preventDefault();
 
        $.ajax({
            url: "API/api_stop.php",
            type: "POST",
            error: function(e){
                console.log(e);
            },
            success: function(result){
                console.log(result);
            }
        });


    });



});