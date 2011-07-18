<?php
/**
 * plugin name: WP Age Verification
 * description: It allows the admin to make age limit for the posts and pages of his sites
 * author: Mahibul Hasan
 * Author URI: http://hasan-sohag.blogspot.com
 * 
 */
 
 if(!class_exists('wp_age_verification')) : 
 
 class wp_age_verification{


function wp_age($content){
	$options = get_option('settings_api');
	$color = $options['color'];
	$font = "'".$options['font']."'";
	$fontsize = $options['fontsize'].'px';
	$margin = $options['margin'].'px';
		
	 $d = <<<eof
<hr/>
<div style="background-color:$color;font:$fontsize $font" id="wpage">
<div style="margin-left:$margin">
	<p class="bithtitle">PLEASE ENTER YOUR DATE OF BIRTH</p>
	<form method="post" action="">				
	DAY: <input id="day" name="age[day]" type="text" value="" /> MONTH: <input id="month" name="age[month]" type="text" value="" /> YEAR: <input id="year" name="age[year]" type="text" value="" />
	<br/>
	<span class="formsubmit">	
	<input type="submit" name="wpageverification" id="agesubmit" value="ENTER" /> <input type="reset" value="RESET" />
	</span>
	</form>
</div>
</div>
<br/><hr/>
eof;
		
		if(strstr($content,'[wpage]')){
					
			if($_COOKIE['wpage'] == 'no'){
				$options = get_option('settings_api');			
				$d = $options['onlytext'];
			}
			if($_COOKIE['wpage'] == 'yes'){
				//$d = $content;
				$d = preg_replace('/\[wpage\]/','',$content);
			}
		}
		else{
			$d = $content;
		}
		//sreturn '';
		return $d;
		
	}
	
	function css_adition(){
		wp_register_style('wp_age_verification',plugins_url('/',__FILE__).'css/style.css');
		wp_enqueue_style('wp_age_verification');	
	}
	
	function javascript_adition(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('wpageverification',plugins_url('/',__FILE__).'js/wpage.js',array('jquery'));
	}
	
	function sessionfunction($a,$b){
		$day = preg_replace('/[^0-9]/','',$a['day']);
		$month = preg_replace('/[^0-9]/','',$a['month']);
		$year = preg_replace('/[^0-9]/','',$a['year']);
		$age = $this->birthday($year.'-'.$month.'-'.$day);
		$options = get_option('settings_api');
		$checkage = ($options['age'])?($options['age']) :18;
		if($age<$checkage){
			if(!$_COOKIE['wpage']){
				setcookie('wpage','no',time()+86400*30,'/');
			}
		}
		else{
			if(!$_COOKIE['wpage']){
				setcookie('wpage','yes',time()+86400*30,'/');
			}
		}
		
		$url = 'http://'.$b;		
		header("Location: $url");
		exit;	
	}
	
	function birthday($birthday){
		list($year,$month,$day) = explode("-",$birthday);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($month_diff < 0) $year_diff--;
		elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
		return $year_diff;
	 }
	 
	 
	
}

$wpage = new wp_age_verification();

//session function
if($_REQUEST['wpageverification']){
	//$wpage->sessionfunction($_REQUEST['age'],$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
	$wpage->sessionfunction($_REQUEST['age'],$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
}

//add_shortcode('wpage',array($wpage,'wp_age'));
add_action('wp_print_styles',array($wpage,'css_adition'),100);
add_action('wp_print_scripts',array($wpage,'javascript_adition'));
add_filter('the_content',array($wpage,'wp_age'));


endif;

include("wp-age-settings.php");
  
?>
