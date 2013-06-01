$(document).foundation();

function showModal(template, url, need_close_btn) {
    var close_btn = (need_close_btn == false) ? '' : '<a class="close-reveal-modal">&#215;</a>';
    var html = $('#'+template).html();
    $('#modal').html('<div class="loader"></div>');
    if (typeof url === "string") {
        $.getJSON(url, function(data) {
            console.log(data);
            $('#modal').html(Mustache.to_html(html, data)).prepend(close_btn);
        });
    } else {
        $('#modal').html(html).prepend(close_btn);
    }
    $('#modal').foundation('reveal', 'open');
}

$(document).ready(function () {
    // Pun gestion
    if ($(".tab.active").length == 1) {
        var position = $(".tab.active a").position().left + $(".tab.active a").width()/2 - 7;
        $("#poc").css('left', position).show();
    }
    $(window).resize(function() {
        if ($(".tab.active").length == 1) {
            var position = $(".tab.active a").position().left + $(".tab.active a").width()/2 - 7;
            $("#poc").css('left', position).show();
        }
    });
    $('#modal').on('click', '.close-modal', function () {
        $('#modal').foundation('reveal', 'close');
    });
});
