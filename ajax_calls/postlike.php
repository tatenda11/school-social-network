<?php
include_once("../libs/autoload.php");
  function sendemail($email,$tokken,$id){
        try{
            $sent = false;
            $mail = new PHPMailer;
            //From email address and name
            $mail->From = "tatemunenge@gmail.com";
            $mail->FromName = "Creative Studios";
            $mail->addAddress($email, "solusi-fi user");
            //Address to which recipient will reply
            $mail->addReplyTo("tatemunenge@munenge", "Reply");
            //html mode
            $mail->isHTML(true);
            $mail->Subject = "Account Activation";
            $mail->Body="click this link to activate <a href='https://www.solusi-fi.com/activate.php?tokken=$tokken&candy=$id'>click here</a>"; 
            $mail->AltBody = "hello user you have successifully created an elearning account with the elearning institute your login creditials are email:thank you very much http://www.elearninginstitute.biz";
            if($mail->send()) {
               echo "not sent";
             }
              return $sent;
         }
         catch(Exception $e){
            die("could not sent email");
         }
     }  

     function send_email($from,$subject,$msg)
{
	$to = "2013050071@solusi.ac.zw";
	$headers ="From:$from\n";
    $headers .="Content-type:text";
    $mail_sent = mail($to,$subject,$msg,$headers);
    if($mail_sent)
    {
    	echo "sent";
    }	
    else
    {
    	echo "not sent";
    }	
}

//sendemail("2013050071@solusi.ac.zw","wretrtyuli","5");
 
 send_email("tatemunenge@rmail.com","test","testing stuff");









