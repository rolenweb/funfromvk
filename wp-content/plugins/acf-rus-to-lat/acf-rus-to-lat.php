<?php
/*
Plugin Name: Advanced Custom Fields: Rus-To-Lat
Plugin URI: https://qcust.com/acf-rus-to-lat/
Description: Add-On plugin for Advanced Custom Fields (ACF) that converts Cyrillic characters in field name to Latin characters. Send your suggestions and critics to <a href="mailto:andreykashops@gmail.com">andreykashops@gmail.com</a>.
Author: Andrey Pavluk <andreykashops@gmail.com>
Version: 1.0.0 
*/ 


class acf_rustolat {
	
	function __construct(){
			
		add_action('acf/field_group/admin_enqueue_scripts', array($this, 'enqueue_script') );
		
	}
	
	
	
	
	/*
	*  enqueue_script
	*
	*  @description: 
	*  @since 1.0.0
	*  @created: 31/08/16
	*/
	function enqueue_script(){
		
		if( function_exists('wp_add_inline_script') ){
			wp_add_inline_script('acf-field-group', $this->script() );
		}else{
			add_action('admin_footer', array($this, 'script_to_footer'));
		}
		
		
	}
	
	
	
	
	/*
	*  script_to_footer
	*
	*  @description: 
	*  @since 1.0.0
	*  @created: 31/08/16
	*/
	function script_to_footer(){

		$script = $this->script();
		
		echo '<script type="text/javascript">'. $script .'</script>';
		
		
	}
	
	
	
	
	/*
	*  script
	*
	*  @description: Return script data
	*  @since 1.0.0
	*  @created: 31/08/16
	*/
	function script(){

		$script = "
		(function($){
			$(document).on('keyup', '#acf_fields .field_form tr.field_name input.name', function(){
				var val = $(this).val();
				var replace = {
					'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh', 
					'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
					'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
					'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya'
				}
				
				$.each( replace, function(k, v){
					var regex = new RegExp( k, 'g' );
					val = val.replace( regex, v );
				});
				
				val = val.replace( /[^\w\d-_]/g, '' );
				
				$(this).val(val);
				$(this).closest('.field').find('div.field_meta td.field_name').text(val);
				
			});
		})(jQuery)";
		
		return $script;
		
	}
	
}

new acf_rustolat();
