$(document).ready(function(){
    var $container = $('.wrapper');

    $container.imagesLoaded( function(){
        $container.masonry({
            itemSelector : '.post'
        });
    });
});