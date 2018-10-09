/*
 * Run when the page is ready. 
 */
(function($) {
	/*
	 * On load of the Twitter widget software.  
	 */
	TwitterWidgetsLoader.load(function(twttr) {
		twttr.widgets.createTimeline(
				$('#twitter-widget').data('widget'),
				document.getElementById("twitter-widget"), 
				{
					theme: "dark"
				}
		);
	});
}(jQuery));

