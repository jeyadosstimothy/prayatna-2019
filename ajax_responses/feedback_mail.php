<?php

require 'mail.php';

$email= $_POST['email'];
$query = $_POST['query'];

$subject = "Thanks for reaching out to us!";

$body_content = "Greetings from ACT!

We, the Association of Computer Technologists, have received the following query from you:

" . $query ."

One of our team members will contact you soon. Stay Tuned!

Ignite. Inspire. Innovate.

Regards,
Team ACT,
Prayatna 2k19
";

send_mail($email, $subject, $body_content);


$subject = 'Query: ' . $email;
send_mail($prayatna_email, $subject, $query);

?>