<?php

require_once dirname("../composer.json") . "/src/config/Email/PHPMailer/PHPMailer.php";
require_once dirname("../composer.json") . "/src/config/Email/PHPMailer/SMTP.php";
require_once dirname("../composer.json") . "/src/config/Email/PHPMailer/Exception.php";

//use Exception;
use stdClass;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {

    /** @var PHPMailer */
    private $mail;

    /** @var stdClass */
    private $data;

    /** @var Exception */
    private $error;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->data = new stdClass();

//        $this->mail->IsSMTP();
        $this->mail->IsHTML();
        $this->mail->setLanguage("br");
//        $this->mail->SMTPAuth = true;
//        $this->mail->SMTPSecure = "tls";
        $this->mail->CharSet = "utf-8";

        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = "587";
        $this->mail->Username = "exitoriorevistadigital@gmail.com";
        $this->mail->Password = "bTkYs+>aMWS\ZKNV";

        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

    }

    public function add($subject, $body, $recipient_name, $recipient_email) {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipient_name = $recipient_name;
        $this->data->recipient_email = $recipient_email;
        return $this;
    }

    public function attach($filePath,  $fileName) {
        $this->data->attach[$filePath] = $fileName;
    }

    public function send($from_name, $from_email = "exitoriorevistadigital@gmail.com") {
        try {
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->body);
            $this->mail->addAddress($this->data->recipient_email, $this->data->recipient_name);
            $this->mail->setFrom($from_email, $from_name);

            if (!empty($this->data->attach)) {
                foreach ($this->data->attach as $path => $name) {
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->send();
            return true;

        } catch (Exception $exception) {
            $this->error = $exception;
            return false;
        }
    }

    public function error() {
        return $this->error;
    }
}