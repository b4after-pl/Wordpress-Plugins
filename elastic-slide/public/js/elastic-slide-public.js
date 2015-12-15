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
            var closeTag = $('.elastic-slider-body span.close-tag');
            
            // functions
            function elasticIntro(elasticSlider, start) 
            {
                // display slider with setup time in php
                setTimeout(function() {
                    elasticSlider.addClass('elastic-slider-body-intro');
                    
                }, start);
            }
            
            function elasticOutro(elasticSlider)
            {
                elasticSlider.addClass('elastic-slider-body-outro');
            }
            
            function elasticInit(elasticSlider)
            {
                elasticSlider.css('animationDuration', php_vars.elastic_slider_animation_duration+'s');
//                console.log(php_vars.elastic_slider_animation_duration);
//                console.log(elasticSlider.css('animationDuration'));
            }
            
            // runs
            // php_vars - data pased by wp_localize_script;
            elasticInit(elasticSlider,php_vars.elastic_slider_animation_duration);
            elasticIntro(elasticSlider, php_vars.elastic_slider_start_delay);
//            
            closeTag.click(function() {
                elasticOutro(elasticSlider);
            });
        });

})( jQuery );
