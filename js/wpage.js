jQuery(document).ready(function($){
	//alert('g');
	$('#agesubmit').click(function(){
		var day = $('#day').val();
		var month = $('#month').val();
		var year = $('#year').val();
		
		if(problem(year,4,'y')){
			classadding('#year',false);
			if(problem(month,2,'m')){
				classadding('#month',false);
				if(problem(day,2,'d')){
					classadding('#month',false);
				}
				else{
					alert('Please Check the Day!');
					classadding('#day',true);
					return false;
				}
			}
			else{
				alert('Please Check the Month!');
				classadding('#month',true);
				return false;
			}
		}
		else{
			alert('Please Check the Year!');
			classadding('#year',true);
			return false;
		}
		
	});
	
	// remove multiple, leading or trailing spaces
	function trim(s) {
		s = s.replace(/(^\s*)|(\s*$)/gi,"");
		s = s.replace(/[ ]{2,}/gi," ");
		s = s.replace(/\n /,"\n");
		return s;
	}
	
	function problem(t,check,a){
		
		if(numbercheck(t,check,a)){
			return true;
		}
		else{
			return false;
		}
	}
	
	function classadding(a,b){
		if(b){
			$(a).css({'background-color':'#F19F99'});
		}
		else{
			$(a).css({'background-color':'#FFFFFF'});
		}
	}
	
	function numbercheck(zip,check,a){
		zip = trim(zip);
		
		var num = /^-{0,1}\d*\.{0,1}\d+$/;
		if(num.test(zip) == true){
			if(zip.length == check){
				return valuecheck(zip,a);
			}
			else{
				return false;
			}
			
		}
		else{
			return false;
		}
	}
	
	function valuecheck(zip,a){
		if(a == 'y'){
			if(zip > 1920 && zip<2050){
				return true;
			}
			else{
				return false;
			}
		}
		
		else if(a == 'm'){
			if(zip > 0 && zip < 13){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			if(zip > 0 && zip < 31){
				return true;
			}
			else{
				return false;
			}
		}
	}
	
	
});
