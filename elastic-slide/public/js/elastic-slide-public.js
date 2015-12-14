(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
        
        $(function() {
            
            // definitions
            var elasticSlider = $('.elastic-slider-body');
            var elasticSliderPosition = elasticSlider.css('margin-left');
            
            function elasticInit(elasticSlider)
            {
                elasticSlider.css('margin-left', '-100%');
            }
            
            // functions
            function elasticIntro(elasticSlider, elasticSliderPosition) 
            {
                elasticSlider.animate({marginLeft: elasticSliderPosition}, 2500);
                //console.log(elasticSliderPosition);
            }
            
            // runs
            elasticInit(elasticSlider);
            elasticIntro(elasticSlider, elasticSliderPosition);
        });

})( jQuery );
