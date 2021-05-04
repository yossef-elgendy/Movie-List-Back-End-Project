$(document).ready(function (){

    var link = window.location.pathname.slice(17);
    $('#links li a').each(function (){
        if(!($(this).attr('href') == link))
        {
            $(this).removeClass('active').removeClass('nav-link-hover-active').addClass('nav-link-hover');

        }
        else
        {
            $(this).addClass('active').addClass('nav-link-hover-active').removeClass('nav-link-hover');
        }
    });

});