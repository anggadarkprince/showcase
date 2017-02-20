// font loader
var WebFontConfig = {
    google: {
        families: [
            'Roboto:300,400,500,700'
        ]
    },
    timeout: 2000
};

(function () {
    "use strict";
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.async = 'true';
    document.head.appendChild(wf);
    console.log('fonts loading');
})();
