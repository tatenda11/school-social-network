$(function(){
	$('.en-icons').on('click',function(){
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
		var user = $(this).attr('rel');
	    //$('#view_comments'+box).fadeIn(450);
	    getComments(box,user);

	});	

	$('.click-hide').on('click',function(){
		$(this).fadeOut(200);
	});

	$('.msg-snip a').on('click',function(){
		var box = $(this).attr('id');
		 openMessage(box);
	    $('#showmessage'+box).toggle(450);
	});

	jQuery("time.timeago").timeago();
	$('#navigation-mobila').on('click',function(){
		$('.site-navigation').toggle(450);
	});	

	$("#btnUploadNotes").on("click", function() {
		var file_data = $("#txtfile").prop("files")[0];   
    	var form_data = new FormData();                  
    	form_data.append("file", file_data)
    	alert(form_data);                             
    	$.ajax({
                url: "/notes",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(){
                    alert("works"); 
                }
     	});
	});	

});
 

function showAjaxWorking(){
	$('#ajax-loading').fadeIn(400);
}

function hideAjaxWorking(){
	$('#ajax-loading').fadeOut(400);
}

function sendPost(user_posted,wall_posted){
	showAjaxWorking();
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
				hideAjaxWorking();
			}		
		}
	}
}

function sendPostPage(page){
	showAjaxWorking();
	var pvt = $("#txtprivacy").val();
	var text = $("#txtpost").val();
	var photo = $("#txtphoto").val();
	var youtube = $("#txtyoutube").val();
	if(text.length !=0){
		var hr = new XMLHttpRequest();
		var url = "./ajax_calls/sendpost.php";
		var vars = "pvt="+pvt+"&text="+text+"&photo="+photo+"&youtube="+youtube+"&wall="+page+"&user=0"+"&setpost_page=1";
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
				hideAjaxWorking();
			}		
		}
	}

}

function openMessage(id){
	 showAjaxWorking();
	 var hr = new XMLHttpRequest();
	 var url = "./ajax_calls/sendpost.php?open_msg=true&id="+id;
	 hr.open("POST",url,true);
	 hr.send();
	 hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status == 200){
			var data = hr.responseText;
			var data = hr.responseText;
			if(data == "done"){
				$('#msg-holder'+id).removeClass('msgMark');
				hideAjaxWorking()
			}
		}		
	}

}
function getComments(id,user){
	showAjaxWorking();
	var hr = new XMLHttpRequest();
	var url = "./ajax_calls/magicBox.php?comment=true&post="+id+"&user="+user;
	hr.open("POST",url,true);
	hr.send();
	$('#ajaxresponse'+id).html("loading");
	$('#view_comments'+id).fadeIn(450);
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status == 200){
			var data = hr.responseText;
			var data = hr.responseText;
			$('#ajaxresponse'+id).html(data);
			hideAjaxWorking();	
		}		
	}
}

function sendComment(postId,owner){
	showAjaxWorking();
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
				hideAjaxWorking();
			}	
		} 	
	}
}

function sendLike(post,user,typ,owner){
	showAjaxWorking();
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
				hideAjaxWorking();
			}
			else{
				$('#like-span'+post).removeClass('blue');
				hideAjaxWorking();	
			}
		}	
	} 

}
function sendLikePage(post,user,typ,owner){
	showAjaxWorking();
	var url = "./ajax_calls/sendpost.php?post="+post+"&type="+typ+"&owner=0"+"&like="+true;
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
				hideAjaxWorking();
				alert('you have liked this page');	
			}
		}	
	} 
}

function likeComment(commentId,liker,user){
	showAjaxWorking();
	var url = "./ajax_calls/likecomments.php?likeComment=true&commentId="+commentId+"&user="+user+"&type=C";
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status == 200){
			var result = hr.responseText;
			alert(result);
			if(result == "liked"){
				$('#like-span-comment'+commentId).html('unlike');
				var likes = $('#comment-num'+commentId).attr('rel');
				likes =parseInt(likes) + 1;
				$('#comment-num'+commentId).html("");
				$('#comment-num'+commentId).html("<i class='fa fa-thumbs-up fa-fw'></i>"+likes);
				var commmentCounter = document.getElementById('comment-num'+commentId);
				commmentCounter.rel = likes;
				hideAjaxWorking();
			}
			else if(result == "unliked"){
				$('#like-span-comment'+commentId).html('like');
				var likes = $('#comment-num'+commentId).attr('rel');
				likes = parseInt(likes) - 1;
				$('#comment-num'+commentId).html("");
				$('#comment-num'+commentId).html("<i class='fa fa-thumbs-up fa-fw'></i>"+likes);
				//$('#comment-num'+commentId).attr('rel') = likes;
				var commmentCounter = document.getElementById('comment-num'+commentId);
				commmentCounter.rel = likes;
				hideAjaxWorking();
			}
			else{
				hideAjaxWorking();
			}
		}
	}
}

function setVal(id,value){
	//$('#'+id).val(value);
	document.getElementById(id).value = value;
}

function sendAttend(status){
	var act = $('#setEvent').val();
	var url = "./ajax_calls/parseEvents.php?act="+act+"&status="+status;
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText; 
			alert(result);
		}	
	}	
}

function getCord(user){
	var url = "./ajax_calls/parseEvents.php?user="+user;
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			//alert(result);
			$('#co-odinator-info').html(result);
		}	
	} 	
}
function addFriend(from,to){
	showAjaxWorking();
	var url = "./ajax_calls/parseFriends.php?from="+from+"&to="+to+"&action=add";
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('#request-feedback'+to).html(result);
			alert('friend request sent');
			hideAjaxWorking();
		}	
	} 
}
    
function removeFriend(id,div){
	var url = "./ajax_calls/parseFriends.php?id="+id+"&action=remove";
	alert(url);
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('#request-feedback'+div).html(result);
			alert('request deleted');
		}	
	} 
}
    
function deleteRequest(id){
	showAjaxWorking();
	var url = "./ajax_calls/parseFriends.php?id="+id+"&action=remove";
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('#'+id).html("<h3>Request deleted</he>");
			hideAjaxWorking();
		}	
	} 
}

function acceptRequest(id){
	var url = "./ajax_calls/parseFriends.php?id="+id+"&action=accept";
	var hr = new XMLHttpRequest();
	hr.open("POST",url,true);
	hr.send();
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			$('#'+id).html(result);
		}	
	} 
}

function sendMessage(id){
	var hr = new XMLHttpRequest();
	var msg = $('#txtmsg').val();
	var url = "./ajax_calls/sendpost.php";
	var vars = "id="+id+"&msg="+msg;
	if(msg.length > 0){
		hr.open("POST",url ,true);
		hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
		hr.send(vars);
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status==200){
				var result = hr.responseText;
				$('#txtmsg').val("");
				var link = "<a class='pull-right' href='conversations.php?with="+id+"'>view conversation</a>";
				$('#txtReply').val("");
				$('#request-feedack'+key).html("<div class='alert alert-success' role='alert'>Your message has been sent "+link+" </div>");
			}	
		} 	
	}	
}

function deletePost(post){
	var url = "./ajax_calls/sendpost.php?deletepost=true&itemactive="+post;
	var hr = new XMLHttpRequest();
	hr.open("POST",url ,true);
	hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	hr.send();	
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			alert(result);
		}	 
	}
}
function deleteComment(id){
	var url = "./ajax_calls/sendpost.php?deleteComment=true&commentactive="+id;
	var hr = new XMLHttpRequest();
	hr.open("POST",url ,true);
	hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	hr.send();	
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status==200){
			var result = hr.responseText;
			alert(result);
		}	 
	}
}

function sendReply(id,key){
	var msg = $('#txtReply'+key).val();
	var url = "./ajax_calls/sendpost.php";
	var vars = "id="+id+"&msg="+msg;
	var hr = new XMLHttpRequest();
	if(msg.length > 0){
		hr.open("POST",url ,true);
		hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
		hr.send(vars);	
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status==200){
				var result = hr.responseText;
				var link = "<a class='pull-right' href='conversations.php?with="+id+"'>view conversation</a>";
				$('#txtReply'+key).val("");
				$('#request-feedack'+key).html("<div class='alert alert-success' role='alert'>Your message has been sent "+link+" </div>");
			}	 
		}
	}
	
}
