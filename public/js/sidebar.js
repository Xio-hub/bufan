$(function() {
    setNavigation();
});

function setNavigation() {
    var route = window.location.origin + window.location.pathname;

    $("ul.metismenu .nav-second-level a").each(function() {
        var href = $(this).attr('href');
        if (route === href) {
            $(this).parent().parent().closest('li').addClass('active');
            $(this).parent().closest('li').addClass('active');
        }
    });
}