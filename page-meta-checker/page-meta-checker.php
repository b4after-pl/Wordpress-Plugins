<?php
/*
Plugin Name: ExternalMeta tags checker
Plugin URI: http://www.b4after.pl
Version: 1.0.1
Author: BEFORE AFTER
Author URI: http://www.b4after.pl
*/
require_once('meta-parser.class.php');

function createForm($parser)
{
	if(isset($_POST['pageUrl'])) {
		$url = ($parser->checkUrl($_POST['pageUrl']))?$_POST['pageUrl']:null;
	} else {
		$url = null;
	}
	$formHtml ='<form action="" id="webUrlForm"  class="form" method="post">
		<label>
			Podaj adres strony:
		</label>
		<input type="text" name="pageUrl" placeholder="Podaj pełny adres z http://" id="pageUrl" class="form-control" value="'.$url.'">
		<button class="btn btn-success">Sprawdź</button>
	</form>';
	//if($url!==null) $formHtml .= createContent($parser, $url);
	return $formHtml;
}

function createContent($parser) 
{	
	if(isset($_POST['pageUrl'])) {
		$url = ($parser->checkUrl($_POST['pageUrl']))?$_POST['pageUrl']:null;
	} else {
		$url = null;
	}
	$html = '<div class="infoBoxes">';
	if($url!==null):
		$mTags = $parser->getMetaTags($url);
		
		if(isset($mTags['title'])) {
			$html .= '<div class="box-desc">Title strony</div>';
			$html .= '<div class="box-info">'.$mTags['title'].'</div>';
		}
		
		if(isset($mTags['description'])) {
			$html .= '<div class="box-desc">Opis</div>';
			$html .= '<div class="box-info">'.$mTags['description'].'</div>';
		}
		
		if(isset($mTags['keywords'])) {
			$html .= '<div class="box-desc">Słowa kluczowe</div>';
			$html .= '<div class="box-info">'.$mTags['keywords'].'</div>';
		}
		
	endif;
	$html .= '</div>';
	return $html;
}

function formMetaChecker () {
	$parser = new MetaParser();
	return createForm($parser);
}
 
add_shortcode('checker-form', 'formMetaChecker');

function formMetaResults () {

	$parser = new MetaParser();
	return createContent($parser);
}
 
add_shortcode('checker-results', 'formMetaResults');

// Dołączanie styli pluginu

function checker_scripts() {
	wp_enqueue_style( 'website-checker', plugin_dir_url( __FILE__ ).'css/website-checker.css' );
	//wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'checker_scripts' );

?>
