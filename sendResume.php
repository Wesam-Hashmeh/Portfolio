<?php
  if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email_address = $_POST['email_address'];
    $to = $email_address;
    $subject = "My Resume";
    $message = "Dear $name,\n\nPlease find attached my current resume.\n\nBest regards,\n[Your Name]";
    $file_path = "resume.pdf"; // change this to the path of your resume file
    $file_name = "resume.pdf";
    $file_size = filesize($file_path);
    $file_type = mime_content_type($file_path);
    $file_content = file_get_contents($file_path);
    $file_encoded = base64_encode($file_content);
    $boundary = md5(uniqid(time()));
    $headers = "From: [Your Name] <[Your Email Address]>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $message_body = "--$boundary\r\n";
    $message_body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $message_body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $message_body .= $message."\r\n\r\n";
    $message_body .= "--$boundary\r\n";
    $message_body .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
    $message_body .= "Content-Transfer-Encoding: base64\r\n";
    $message_body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
    $message_body .= chunk_split($file_encoded)."\r\n";
    $message_body .= "--$boundary--";
    if(mail($to, $subject, $message_body, $headers)) {
      echo "Resume sent successfully.";
    } else {
      echo "Unable to send resume.";
    }

    ?>