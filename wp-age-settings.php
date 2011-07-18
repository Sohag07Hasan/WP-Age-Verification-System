<?php
/*
 *plugin settings section
 * 
 * */
 
 if(!class_exists('wp_age_settings')) : 
	class wp_age_settings{
		var $message = 'Sorry ! You are not allowed to see the content';
		var $color = '#B9AF7F';
		var $font = 'Times New Roman';
		var $fontsize = 10;
		//creating an options page
		function optionsPage(){
			add_options_page('custom plugins settings','WP Age Verification','activate_plugins','settings-api',array($this,'optionsPageDetails'));
		}
		
		//creating options page in admin panel
		function optionsPageDetails(){
			//starin html form
		?>
			<div class="wrap">
				<?php screen_icon('options-general'); ?>
				<h2>WP Age Verification System</h2>
				<form action="options.php" method="post">
					<?php
						settings_fields('setting_api_demo');
						do_settings_sections('settings-api');
					?>
					<input type="submit" class="button-primary" value="submit" />
				</form>
			</div>
			
		<?php
			
		}
				
		//registering options
		function registerOption(){
			register_setting('setting_api_demo','settings_api',array($this,'data_validation'));
			add_settings_section('first_section',' ',array($this,'first_settings_section'),'settings-api');
			add_settings_field('first_input','Input Your Message',array($this,'first_settings_field'),'settings-api','first_section');
			add_settings_field('second_input','Background-Color (RGB value)',array($this,'second_settings_field'),'settings-api','first_section');
			add_settings_field('third_input','Font Name',array($this,'third_settings_field'),'settings-api','first_section');
			add_settings_field('fourth_input','Font Size (px)',array($this,'fourth_settings_field'),'settings-api','first_section');
			add_settings_field('fifth_input','Age limit (years)',array($this,'fifth_settings_field'),'settings-api','first_section');
			add_settings_field('sixth_input','Left Margin (px)',array($this,'sixth_settings_field'),'settings-api','first_section');
		}
		
		//first_settings_field for the first sections
		function first_settings_field(){
			$text_array = get_option('settings_api');
			$text = $text_array['onlytext'];
		//	echo "<input type='text' name='settings_api[onlytext]' value='$text' /> HTML tags are allowed";
			echo "<textarea rows='3' cols='50' name='settings_api[onlytext]'>$text</textarea>";
		}
		
		//first settins sections callback
		function first_settings_section(){
			echo '<p>The message/text you wanna show if the visitors are below 18  </p>
			<p>The Default message : Sorry! You are not allowed to see the content </p>'
			;
		}
		
		function second_settings_field(){
			$text_array = get_option('settings_api');
			$text = $text_array['color'];
			echo "<input type='text' name='settings_api[color]' value='$text' /> e.g. #FFFFFF";
		}
		
		function third_settings_field(){
			$text_array = get_option('settings_api');
			$text = $text_array['font'];
			echo "<input type='text' name='settings_api[font]' value='$text' /> e.g. arial or 'Times New Roman' etc";
		}
		
		function fourth_settings_field(){
			$text_array = get_option('settings_api');
			$text = $text_array['fontsize'];
			echo "<input type='text' name='settings_api[fontsize]' value='$text' /> e.g. 10,12,15...";
		}
		
		function valuecheck($a,$b,$c){
			$a = (string)$a;
			if(strlen($a)<$b) return $c;
			else return $a;
		}
		
		function fifth_settings_field(){
			$text_array = get_option('settings_api');
			$text = $text_array['age'];
			echo "<input type='text' name='settings_api[age]' value='$text' />";
		}
		
		function sixth_settings_field(){
			$text_array = get_option('settings_api');
			$text = $text_array['margin'];
			echo "<input type='text' name='settings_api[margin]' value='$text' /> Left margin for Form";
		}
		
		//validating data
		function data_validation($data){
			$valid = array();
			$valid['onlytext'] = $this->valuecheck(trim($data['onlytext']),5,$this->message);
			$font = preg_replace('/[^a-z A-Z]/','',$data['font']);			
			$valid['font'] = $this->valuecheck($font,3,$this->font);			
			$valid['color'] = $this->valuecheck(trim($data['color']),3,$this->color);			
			$valid['age'] = preg_replace('/[^0-9]/','',$data['age']);			
			$valid['fontsize'] = preg_replace('/[^0-9]/','',$data['fontsize']);			
			 $margin = preg_replace('/[^0-9]/','',$data['margin']);	
			 $valid['margin'] = ($margin)? $margin : 5;		
			return $valid;
		}
	}
	
	$settings_api = new wp_age_settings();
	add_action('admin_menu',array($settings_api,'optionsPage'));
	add_action('admin_init',array($settings_api,'registerOption'));
endif;

?>
