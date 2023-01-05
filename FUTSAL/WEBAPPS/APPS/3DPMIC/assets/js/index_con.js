$(document).ready(function() {
	setTimeout( function() {
	    $('#fullpage').fullpage({
	        verticalCentered: true,
	        anchors: ['anchor1', 'anchor2', 'anchor3', 'anchor4'],
	        menu: '#remote'
	    });
	}, 500);
});