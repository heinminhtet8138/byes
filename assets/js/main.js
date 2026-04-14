/* Main JavaScript for Boot Your English Skills */

$(document).ready(function() {
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });

    // Add active class to current nav item
    var path = window.location.pathname;
    $('.navbar-nav .nav-link').each(function() {
        if ($(this).attr('href') === path) {
            $(this).addClass('active');
        }
    });

    // Simple form validation feedback
    $('form').on('submit', function() {
        var btn = $(this).find('button[type="submit"]');
        if ($(this)[0].checkValidity()) {
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
        }
    });
});
