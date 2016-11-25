$(function(){
	$('#edit-info-header .nav-pills li').on('click',function(){
		var panel_to_show = $(this).attr('rel');
		var panal_showing = $('#edit-info-container #edit-info-box .info-elements .display');
		//alert( panel_to_show);
		$('#edit-info-header .nav-pills li').removeClass('active');
		$(this).addClass('active');
		//$('#edit-info-container  #edit-info-box .info-elements.display').removeClass('display');
		$('#edit-info-container  #edit-info-box .info-elements.display').removeClass('display');
		$('#'+panel_to_show).addClass('display');
	});		
	$('#overlay').on('click',function(){
	$(this).fadeOut(300);
	document.getElementById("processing").innerHTML = '';	
	});

	$('#updatePass').on('click',function(){
		var oldPass = $('#txtpassold').val();
		var newPass = $('#txtpassnew1').val();
		var newPass2 = $('#txtpassnew2').val();
		changePass(oldPass,newPass,newPass2);
 	});

 	$('#updateSettings').on('click',function(){
 		var settting = $('#txtAccess').val();
 		updateSettings(settting);
 	});
});

			var success = '<div class="panel panel-default"><div class="panel-heading">Update profile information</div><div class="panel-body"><h5>Profile Update Success</h5></div></div>';
			function updatePersonal(){
				var fname =  $("#txtFname").val();
				var sname = $("#txtLname").val();
				var htown =  $("#txtTown").val();
				var mname = $("#txtMname").val();
				var bday = $("#datepicker").val();
				alert(bday);
				var bio = $("#txtbio").val();
				if(fname.length==0 || sname.length ==0){
					alert('first name and surname cant be blank');
				} 
				else{
					$("#overlay").fadeIn(700);
					var hr = new XMLHttpRequest();
					var url = "./ajax_calls/profileInfo.php";
					var vars = "fn="+fname+"&sn="+sname+"&htown="+htown+"&mname="+mname+"&bday="+bday+"&bio="+bio+"&personal="+1;
					hr.open("POST",url ,true);
					hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
					hr.send(vars);
					hr.onreadystatechange = function(){
						if(hr.readyState == 4 && hr.status == 200){
							var data = hr.responseText;
							var data = hr.responseText;
							if(data == "updated"){
								document.getElementById("processing").innerHTML = "";
								document.getElementById("processing").innerHTML =  success;
							}
							else{
								document.getElementById("processing").innerHTML = "";
								document.getElementById("processing").innerHTML =  data;	
							}
						}		
					}
				}			
			}
			
			function updateAcademic(){
				$("#overlay").fadeIn(700);
				var level =  $("#txtlevel").val();
				var hostel = $("#txthostel").val();
				var major =  $("#txtmajor").val();
				var school = $("#txtschool").val();
				var hr = new XMLHttpRequest();
				var url = "./ajax_calls/profileInfo.php";
				var vars = "level="+level+"&hostel="+hostel+"&major="+major+"&school="+school+"&academic="+1;	
				hr.open("POST",url ,true);
				hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
				hr.send(vars);
				hr.onreadystatechange = function(){
					if(hr.readyState == 4 && hr.status == 200){
						var data = hr.responseText;
						if(data == "updated"){
							document.getElementById("processing").innerHTML = "";
							document.getElementById("processing").innerHTML =  success;
						}
					}		
				}
			}

			function changePass(oldPass,newPass,newPass2){
				if(newPass == newPass2){
					var url ="./ajax_calls/profileInfo.php?changePass=true&oldpass="+oldPass+"&newPass="+newPass;
					var hr = new XMLHttpRequest();
					hr.open("POST",url ,true);
					hr.send();
					hr.onreadystatechange = function(){
						if(hr.readyState == 4 && hr.status == 200){
							var data = hr.responseText;
							if(data == "passChanged"){
								$('#overlay').fadeIn(600);
								document.getElementById("processing").innerHTML = "";
								document.getElementById("processing").innerHTML =  success;
							}
							else if(data == "1"){
								alert('could update password your old password was entered incorrectly');
							}
							else{
								alert('general error please try later');
							}	
						}					
					} 
				}
				else{
					alert('password dont match');
				}
			}

			function updateSettings(setting){
				if(setting == "F" || setting == "E"){
					var url = "./ajax_calls/updatesettings.php?setting="+setting;
					var hr = new XMLHttpRequest();
					hr.open("POST",url,true);
					hr.send();
					hr.onreadystatechange = function(){
					if(hr.readyState == 4 && hr.status == 200){
						var data = hr.responseText;
						if(data == "updated"){
							$('#overlay').fadeIn(600);
							document.getElementById("processing").innerHTML = "";
							document.getElementById("processing").innerHTML =  success;
						}
						else{
							alert('could not update please try again');
						}
					}		
				}	
				}
			}



