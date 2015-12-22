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
                elasticSlider.css('backgroundColor', php_vars.elastic_slider_background_color);
                elasticSlider.css('color', php_vars.elastic_slider_font_color);
                if(php_vars.elastic_slider_background_type=='gradient')
                {
                    elasticSlider.css('background', php_vars.elastic_slider_background_color_start);
                    elasticSlider.css('background', '-webkit-linear-gradient('+php_vars.elastic_slider_background_color_start+', '+php_vars.elastic_slider_background_color_end+')');
                    elasticSlider.css('background', '-o-linear-gradient('+php_vars.elastic_slider_background_color_start+', '+php_vars.elastic_slider_background_color_end+')');
                    elasticSlider.css('background', '-moz-linear-gradient('+php_vars.elastic_slider_background_color_start+', '+php_vars.elastic_slider_background_color_end+')');
                    elasticSlider.css('background', 'linear-gradient('+php_vars.elastic_slider_background_color_start+', '+php_vars.elastic_slider_background_color_end+')');
                    
                }
                elasticSlider.css('border-radius', php_vars.elastic_slider_border_radius);
            }
            
            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays*60*1000));
                var expires = "expires="+d.toUTCString();
                document.cookie = cname + "=" + cvalue + "; " + expires;
            }
            // runs
            // php_vars - data pased by wp_localize_script;
            elasticInit(elasticSlider);
            elasticIntro(elasticSlider, php_vars.elastic_slider_start_delay);
//            
            closeTag.click(function() {
                elasticOutro(elasticSlider);
                var cookiePeriod = php_vars.elastic_slider_cookie_period;
                setCookie('elastic_slider_cookie', 'true', cookiePeriod);
            });
        });

})( jQuery );
