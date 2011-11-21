function formatTitle(title, currentArray, currentIndex, currentOpts) {
    return '<div id="tip7-title">' + (title && title.length ? '<b>' + title + '</b>' : '' ) + '</div>';
}

$(document).ready(function() {

	$("a.premio_link").fancybox({
		'titlePosition' 		: 'inside',
		'titleFormat'		: formatTitle
		});	
});