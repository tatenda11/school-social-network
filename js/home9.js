$(function(){
	$('.en-icons').on('click'
		var textbox = $(this).attr('rel');
		$('#'+textbox).fadeIn(300);	
	});
	$('#privacy li a').on('click',function(){
		var status = $(this).attr('rel');
		document.getElementById("statustext").innerHTML = status;
		document.getElementById("txtprivacy").value = status;
	});
	$('.show-comment').on('click',function(){
		var box = $(this).attr('id');
	    $('#view_comments'+box).fadeIn(450);
	});	

	$('.click-hide').on('click',function(){
		$(this).fadeOut(200);
	});

	$('.msg-snip a').on('click',function(){
		var box = $(this).attr('id');
	    $('#showmessage'+box).toggle(450);
	});

	jQuery("time.timeago").timeago();

});
 


function sendPost(user_posted,wall_posted){
	var pvt = $("#txtprivacy").val();
	var text = $("#txtpost").val();
	var photo = $("#txtphoto").val();
	var youtube = $("#txtyoutube").val();
	var wall = wall_posted;
	var user = user_posted;
	if(text.length !=0){
		var hr = new XMLHttpRequest();
		var url = "./ajax_calls/sendpost.php";
		var vars = "pvt="+pvt+"&text="+text+"&photo="+photo+"&youtube="+youtube+"&wall="+wall+"&user="+user+"&setpost_me=1";
		hr.open("POST",url ,true);
		hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
		hr.send(vars);
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
				var data = hr.responseText;
				var data = hr.responseText;
				//alert(data);
				$('#newsfeed').prepend(data).hide().fadeIn('slow');
				$('#txtpost').val("");
			}		
		}
	}
}
function sendComment(postId,owner){
	var comment = $("#txtPostComment"+postId).val();
	if(comment.length > 0){
		$("#txtPostComment"+postId).val(""); 
		var hr = new XMLHttpRequest();
		var url = "./ajax_calls/sendpost.php?comment="+comment+"&post="+postId+"&owner="+owner;
		hr.open("POST",url,true);
		hr.send();
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status==200){
				var result = hr.responseText;
				$('#ajaxresponse'+postId).prepend(result).hide().fadeIn('slow');
			}	
		} 	
	}
}

function sendLike(post,user,typ,owner){
	var url = "./ajax_calls/sendpost.php?post="+post+"&type="+typ+"&owner="+owner+"&like="+true;
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			//$('#ajaxresponse'+postId).prepend(result).hide().fadeIn('slow');
			//alert(result);
			$('#like-span'+post).html(result);
			if(result == "<i class='fa fa-thumbs-up fa-fw'></i> unlike"){
				$('#like-span'+post).addClass('blue');
			}
			else{
				$('#like-span'+post).removeClass('blue');	
			}
		}	
	} 

}

function likeComment(commentId,liker,type,user){
	var url = "./ajax_calls/sendpost.php?comment="+commentId+"&user="+user+"&type="+type+"&likeComment=true";
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status == 200){
			var result = hr.responseText;
			$('#like-feedback').html(result);
		}
	}
}

function addFriend(from,to){
	var url = "./ajax_calls/parseFriends.php?from="+from+"&to="+to+"&action=add";
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('#request-feedback'+to).html(result);
		}	
	} 
}
    
function removeFriend(id,div){
	var url = "./ajax_calls/parseFriends.php?id="+id+"&action=remove";
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('#request-feedback'+div).html(result);
		}	
	} 
}

function sendMessage(id){
	var hr = new XMLHttpRequest();
	var msg = $('#txtmsg').val();
	var url = "./ajax_calls/sendpost.php";
	var vars = "id="+id+"&msg="+msg;
	hr.open("POST",url ,true);
	hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	hr.send(vars);
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('#txtmsg').val("");
			$('#request-feedack').html("<div class='alert alert-success' role='alert'>Your message has been sent </div>");
		}	
	} 	

}

function sendReply(id,key){
	var msg = $('#txtReply'+key).val();
	var url = "./ajax_calls/sendpost.php";
	var vars = "id="+id+"&msg="+msg;
	var hr = new XMLHttpRequest();
	hr.open("POST",url ,true);
	hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	hr.send(vars);	
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('#txtReply'+key).val("");
			$('#request-feedack'+key).html("<div class='alert alert-success' role='alert'>Your message has been sent </div>");
		}	
	}
}
