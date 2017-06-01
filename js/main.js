function getTrack(id) {
    $("#loader").html("<img src=img/ellipsis.gif>");

    $.ajax({
        url: 'controller.php/?playlistid='+id,
        dataType: 'json',
        success: function (data) {
            $("#loader").html("");
            $(".list").html("<h1>Youtube Videos</h1>");
             $('html, body').animate({
                    scrollTop: $(".list").offset().top
                }, 2000);
            for (i=0; i < data.length; i++) {
                $(".list").append("<iframe width='560' height='315' src='https://www.youtube.com/embed/"+data[i].youtube_id+"?ecver=1' frameborder='0' allowfullscreen></iframe>");
            }
        },
        error: function (textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}