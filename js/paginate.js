$(function(){
	$('#post-loader').on('click',function(){
		var curPage = $(this).attr('rel');
		var nextPage = curPage + 1; 
		$('#newsfeed-loader').html("<center><img src='./imgs/LoaderIcon.gif'/></center>")
		var hr = new XMLHttpRequest();
		var url = "ajax_calls/paginatenewsfeed.php?page="+curPage;
		hr.open("POST",url,true);
		hr.send();
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status==200){
				var result = hr.responseText;
				alert(result);
				var newHtml = "<span id='post-loader' id='1'><h3>See More Stories</h3></span>";
				$('#newsfeed-loader').html(newHtml);
			}	
		} 	
	});

});
function loadmore(){
	alert('tate');
}

