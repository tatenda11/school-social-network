$(function(){
	$('.magic-box').on('click',function(){
	 	var infoToShow = $(this).attr('rel');
	 	var isMobile = window.matchMedia("only screen and (max-width: 760px)");
		if (isMobile.matches) {
        	window.location.href= infoToShow+'.php';
    	}
    	else{
    		fillDiv(infoToShow);
    		$('#friend-box').slideDown(200);

    	}

	});

	$('#container').on('click',function(){
		$('#friend-box').slideUp();
		$('#friend-box').html("<img src='./imgs/Loadericon.gif'/>");
	});

	$('.show-like-box').on('click',function(){
		var post = $(this).attr('id');
		getLikers(post);
	});

	$('#overlaylikes').on('click',function(){
		$(this).fadeOut();
	});
});

function fillDiv(action){
	var url = "";
	if(action == "notifications"){
		url = "ajax_calls/magicBox.php?content=notifications";
	}
	else{
		url = "ajax_calls/magicBox.php?content=friends";
	}
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('#friend-box').html(result);
		}
	}		
}

function getLikers(post){
	url = "ajax_calls/magicBox.php?getprofiles=notifications&itemId="+post;
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('.liker-holder-box').html(result);
			$('#overlaylikes').fadeIn();
		}
	}		
}

function getLikersComment(post){
	url = "ajax_calls/magicBox.php?getprofilesC=notifications&itemId="+post;
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('.liker-holder-box').html(result);
			$('#overlaylikes').fadeIn();
		}
	}		
}

function memberLiveSearch(key){
	url = "ajax_calls/magicBox.php?content=search&key="+key;
	var isMobile = window.matchMedia("only screen and (max-width: 760px)");
	if (isMobile.matches) {
	}
	else{
		var hr = new XMLHttpRequest();
		hr.open("POST",url,true);
		hr.send();
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status==200){
				var result = hr.responseText;
				$('#content-holder').html(result);
				$('#ajax-search-results').fadeIn();
			}
		}		
	}
}
