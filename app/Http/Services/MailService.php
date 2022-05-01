<?php

namespace App\Http\Services;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use System\Config\Config;

class MailService {
    public function send($emailAddress, $subject, $body) {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = Config::get('mail.SMTP.Host');                //Set the SMTP server to send through
            $mail->SMTPAuth = Config::get('mail.SMTP.SMTPAuth');        //Enable SMTP authentication
            $mail->Username = Config::get('mail.SMTP.Username');        //SMTP username
            $mail->Password = Config::get('mail.SMTP.Password');        //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
            $mail->Port = Config::get('mail.SMTP.Port');                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients
            $mail->setFrom(Config::get('mail.SMTP.setFrom.mail'), Config::get('mail.SMTP.setFrom.name'));
            $mail->addAddress($emailAddress);                           //Add a recipient
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            $result = $mail->send();
            return $result;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}