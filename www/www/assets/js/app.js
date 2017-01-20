(function($){

    $('#logom').click(function(e){
        e.prenventDefault;
        $('body').toggleClass('with--sidebar');
    })

    $('#dimissible').click(function(e){
        e.prenventDefault;
        $('#dimissible').fadeOut();
    })

})(jQuery);