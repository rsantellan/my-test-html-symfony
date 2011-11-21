$(document).ready(function() {

	$("a.grouped_images").fancybox({
		'titlePosition'	:	'inside',
		'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}	
	});	
});