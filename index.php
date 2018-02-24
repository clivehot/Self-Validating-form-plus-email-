<?php

/* It's better to define the empty variables outside the if statement so that HTML has access to them */
$name = "";
$required = "";$emailErr = "";
$sent = "";

if( isset($_POST['submit'])) {
     function security($post) {
		$x = trim($post); 
		$x = stripslashes($x);
		$x = htmlspecialchars($x);  
		return $x;
	}

	/* 	If form is submitted $name becomes the name that is submitted */
	$name = $_POST['name'];
    if(!preg_match("/^[a-zA-Z0-9 ]*$/",$name)) {
	    $required = "*Only letters and numbers allowed";
	} 
    
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format"; 
    }

    $message = $_POST['message'];
    /* Inserts $name,$email into the security function prevents hacking*/
    $name = security($name);
    $email = security($email); 
    $message = htmlspecialchars($message); 
    echo $name;

    /* If there are any errors send "Failed" otherwise send the email */
    if ( strlen($required) > 5  || strlen($emailErr) > 5 ) {
    	$sent = "Failed";
    } else {
        $to = 'youraddress@hotmail.com';
        $email_subject = "Advantage Web Design Enquiey from:  $name";
        $email_body = "You have received a new message from your Advantage Web Design website contact form.\n\n"."From: $name\n\nEmail: $email\n\n$message";
        $headers = "From: noreply@advantage.com\n";
        $headers .= "Reply-To: $email";
        mail($to,$email_subject,$email_body,$headers);

        $sent = "Your message was sent successfully";
        return true;			        
    }


    
}

?>


<html>
<head>
	<style>
	    #error {
	    	       color:red;
	    }    
    </style>
</head>
<body>

<form action="" method="POST" >
    Name: <input type="text" name="name" required><span id="error" ><?php echo $required; ?></span><br>
    Email: <input type="text" name="email" required><span id="error" ><?php echo $emailErr; ?></span><br>
    Message:<input type="textarea" name="message" required>
    <input type="submit" name="submit" value="Submit" >
</form>
<p><?php echo $sent ?></p>

</body>
</html>