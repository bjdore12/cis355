<?php

class Mailer {
    private $to;
    private $subject;
    private $message;
    private $headers;
    private $emailCode;

    public function __construct($recipient, $subject, $message) {
        $this->to = $recipient;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = 'From: meetings@blackmagic.com' . "\r\n" .
            'Reply-To: meetings@blackmagic.com' . "\r\n" .
            'Organization: Blackmagic' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/plain; charset=iso-8859-1' . "\r\n" .
            'X-Priority: 3' . "\r\n" .
            'X-Mailer: smail-PHP/' . phpversion();
    }

    function sendEmailVerify() {
        $this->emailCode = rand();
        $this->subject = "Verify Email";
        $this->message = "Please verify your email by providing the following code: " . $this->emailCode;
        mail($this->to, $this->subject, $this->message, $this->headers);
    }

    function getVerifyCode() {
        if ($this->emailCode != null) {
            return $this->emailCode;
        }
    }
}

//$headers = "MIME-Version: 1.0" . "\r\n";
//$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
