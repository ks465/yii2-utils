/**
 * Create a spinner for showing between page transitions.
 * 
 * @version 0.1.0-941105
 */

$(window).bind('beforeunload', function () {
    var opts = {
            lines: 16 // The number of lines to draw
            , length: 75 // The length of each line
            , width: 15 // The line thickness
            , radius: 50 // The radius of the inner circle
            , scale: 50 // Scales overall size of the spinner
            , color: '#e9481b' // #rgb or #rrggbb or array of colors
        	, trail: 60 // Afterglow percentage
        	, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        	, zIndex: 2e9 // The z-index (defaults to 2000000000)
        	, className: 'spinner' // The CSS class to assign to the spinner
    		, shadow: false // Whether to render a shadow
    		, hwaccel: true // Whether to use hardware acceleration
//            , corners: 1 // Corner roundness (0..1)
//            , opacity: 0.25 // Opacity of the lines
//            , rotate: 0 // The rotation offset
//            , direction: 1 // 1: clockwise, -1: counterclockwise
//            , speed: 1 // Rounds per second
//            , top: '50%' // Top position relative to parent
//            , left: '50%' // Left position relative to parent
//            , position: 'absolute' // Element positioning
    };

    var target = $('#spinner-span');
    var spinner = new Spinner(opts).spin();
    target.append(spinner.el);
});