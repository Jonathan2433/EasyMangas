<?php
if(isset($_POST["submit"])) {
	$name = $_POST["name"];
	$mail = $_POST["mail"];
	$subject = $_POST["subject"];
	$message = $_POST["message"];

	$toEmail = "easymanga.33@gmail.com";
	$mailHeaders = "From: " . $name . "<". $mail .">\r\n";
	if(mail($toEmail, $subject, $message, $mailHeaders)) {
        @session_start();
        $_SESSION['msg'] = "Your contact information is received successfully."; 
        header('Location: contact');
        exit;
	} else {
        @session_start();
        $_SESSION['msg'] = "Failed to send your message ! please try again.."; 
        header('Location: contact');
        exit;
    }
}

