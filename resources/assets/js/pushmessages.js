$(document).ready(function () {
    if ($(".showcase-today-wrapper").length) {
        // listen event name need add . in front to write from namespace (default App\Events)
        window.Echo.private('discovery.portfolio')
            .listen('PortfolioCreated', (data) => {
                console.log(data);
                var portfolio = data.portfolioPushData;

                if (portfolio.interest) {
                    var template =
                        '<div class="col-sm-6 col-lg-4">' +
                        '<div class="panel panel-default portfolio-item">' +
                        '<div class="featured" style="background: url(' + portfolio.featured + ') center center / cover;"></div>' +
                        '<div class="caption">' +
                        '<div class="title-wrapper">' +
                        '<h3 class="title">' +
                        '<a href="' + portfolio.url + '">' + portfolio.title + '</a>' +
                        '</h3>' +
                        '<a href="' + portfolio.author_url + '" class="company">' + portfolio.author + '</a>' +
                        '</div>' +
                        '<hr>' +
                        '<div class="timestamp clearfix">' +
                        '<time class="pull-left">' + portfolio.published + '</time>' +
                        '<div class="pull-right">' +
                        '<a href="' + portfolio.category_url + '">' + portfolio.category +
                        '</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    template = $(template).hide().fadeIn(600);
                    $('.showcase-today-wrapper').prepend(template);
                }
            });
    }

    if ($('.activity-wrapper').length) {
        Echo.private('App.User.' + $('.activity-wrapper').data('id'))
            .notification((notification) => {
                console.log(notification);
                if (!$('#' + notification.id).length) {
                    $('.activity-unread-wrapper li:first-child').after('' +
                        '<li class="m-b-sm" id="' + notification.id + '">' +
                        '<a href="http://account.laravel.com/' + notification.username + '">@' + notification.username + '</a> ' +
                        notification.message + '<span class="label label-primary m-l-sm">NEW</span>' +
                        '<span class="pull-right">a moment ago</span>' +
                        '</li>');
                }
            });
    }
});