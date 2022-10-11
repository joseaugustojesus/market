<?php

namespace app\support;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{


    private $title;
    private $content;
    private $emails;

    public function send()
    {
        try {
            $mail = new PHPMailer();
            $mail->CharSet = 'UTF-8';
            $phpwcms["default_lang"] = "br";
            $mail->IsSMTP();
            $mail->Host = "mail.amsted-maxion.com.br";
            $mail->SMTPAuth = true;
            $mail->Username = "agenda@amsted-maxion.com.br";
            $mail->Password = "agenda$\$amcr##16";
            $mail->From = "agenda@amsted-maxion.com.br";
            $mail->FromName = "Greenbrier Maxion - Portal do Fornecedor";
            foreach ($this->emails as $key => $email) {
                $mail->AddAddress($email);
            }
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->Subject = $this->title;
            $mail->Body .=  $this->content;
            $sended = $mail->send();
            return $sended;
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return null;
        }
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function listEmails($list)
    {
        $this->emails = $list;
    }
}
