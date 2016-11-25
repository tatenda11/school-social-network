<?php 
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myu->getUser($u);
      $error = false;
      $success = false;
      $msg = "";

	require_once("./views/header.php");
      if(isset($_POST['btnCreate'])){
            $title = $_POST['txtname'];
            $des = $_POST['txtabout'];
            $pic = $_FILES['txtbanner']['name'];
            $data = $_FILES['txtbanner']['tmp_name'];
           if(empty($pic)){
              $pic = "default.jpg";
           }
           if(empty($title)){
                  $error = true;
                  $msg = "<div class='alert alert-danger' role='alert'>please provide a name for your page</div>";
           }
           elseif(empty($des)){
                  $error = true;
                  $msg ="<div class='alert alert-danger' role='alert'>please provide a description for your page</div>";
           }
           else{
                  
                  $myp = new fi_pages();
                   //die("<h1>".$u."</h1>");
                  $set = $myp->createPage($myu->systemId,$des,$title,$pic);
                  if($set == true){
                      mkdir("./pages/page$myp->pageId/",0755);
                  }

                  if($pic != "default.jpg"){
                      $path = "./pages/page$myp->pageId/$pic ";
                      $moved = move_uploaded_file($data,$path);
                      //unlink($_FILES['txtbanner']['tmp_name']);
                  }
                  $success = true;
                  $msg =  "<div class='alert alert-success' role='alert'>Your Page has been created <a href='page.php?page=$myp->pageId'>view page</a> </div>";
           }
      }
?>
<style>
body{
	background-color: #f3f3f3;
}
#create-form{
	width: 95%;
	margin-left:3%;
	background-color: #fff;
	height: auto;
      padding: 3%;
      border-radius:13px;
	margin-top: 50px; 
}
 .form_label{
      color:#5bc0de;
      margin-bottom: 17px;
      font-weight: lighter;
      font-size: 19px;
      margin-left: 2px;
}
.mytxt{
      height: 200px !important;
}
</style>

<section>
	<div class='row'>
            <div class="col-sm-6">
                  <div id='create-form'>
                        <form method="post" enctype="multipart/form-data">
                              <div class="form_elements" >
                                    <div>
                                      <?php
                                          if($success == true){
                                             echo $msg;
                                          }
                                          if($error == true){
                                              echo $msg;
                                          }
                                      ?>
                                    </div>
                                    <fieldset>
                                          <div id="request-feedack"></div>
                                          <lebel class="form_label">Page Name</label></br>
                                          <input type="text" name="txtname" class="form-control" placeholder="Page title" aria-describedby="basic-addon3" <?php if($error){echo "value='$title'";}?>/>
                                          </br><lebel class="form_label">About Your page</label></br>
                                          <textarea class="form-control mytxt" name='txtabout' placeholder="about your page" aria-describedby="basic-addon3"><?php if($error){echo $des;}?></textarea>
                                          </br><lebel class="form_label">Upload page banner</label></br>
                                          <input type="file" name="txtbanner" class="form-control" placeholder="upload banner" aria-describedby="basic-addon3"/>                                        
                                          </br><input type="submit" value="Create Page" name="btnCreate" class="btn btn-info"/>
                                    </fieldset>
                              </div>            
                        </form>     
                  </div>
            </div>
            <div class="col-sm-6">
                 <div class='likebox panel panel-default' id='create-form'> 
                        <div class="panel-heading">Why create a page</div>
                             <br> 
                              <ul>
                                    <li>You can rant</li>
                                    <li>Aspire Others</li>
                                    <li>Create a personal page</li>
                                    <li>Create a page for your club or assosiation</li>
                                    <li>What the hack just have fun!!!</li>

                              </ul>
                        </div>
                  </div>
            </div>

      </div>
</section> 
</body>     
</html>