<?php

require  '../PHPMailer/src/Exception.php';
require  '../PHPMailer/src/PHPMailer.php';
require  '../PHPMailer/src/SMTP.php';

$prayatna_email = "prayatna2k19@gmail.com";

function send_mail($email_to, $subject, $body_content, $bcc=false) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = $GLOBALS['prayatna_email'];
    $mail->Password = "Prayatn@19";
    $mail->setFrom($GLOBALS['prayatna_email'], "Team ACT");
    $mail->Subject = $subject;
    $mail->Body = $body_content;
    $mail->AddAddress($email_to);

    if($bcc)
        $mail->AddBCC($GLOBALS['prayatna_email']);

    if(!$mail->Send()) {
        $error = 'Mail error: '.$mail->ErrorInfo;
        error_log($error);
        return false;
    }
    else {
        return true;
    }

}

?>
