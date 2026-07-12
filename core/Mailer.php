<?php 

namespace Ocore;

class Mailer
{
    private \PHPMailer\PHPMailer\PHPMailer $mailer;
    private bool $isDevEnvironment = MAILER['host'] === 'sandbox.smtp.mailtrap.io';

    public function __construct()
    {
        $this->mailer = new \PHPMailer\PHPMailer\PHPMailer();
        $this->mailer->isSMTP();
        $this->mailer->Host = MAILER['host'];
        $this->mailer->SMTPAuth = MAILER['SMTPAuth'];
        $this->mailer->Username = MAILER['username'];
        $this->mailer->Password = MAILER['password'];
        $this->mailer->SMTPSecure = MAILER['SMTPSecure'];
        $this->mailer->Port = MAILER['port'];
        $this->mailer->setFrom(MAILER['from_email'], MAILER['from_name']);
    }

    public function addAddress(string $email, string $name = ''): self
    {   
        $this->mailer->addAddress($email, $name);
        return $this;
    }

    public function setSubject(string $subject): self
    {
        $this->mailer->Subject = $subject;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->mailer->isHTML(true);
        $this->mailer->Body = $body;
        return $this;
    }

    public function addAttachment(
        string $path, 
        string $name = '', 
        string $encoding = \PHPMailer\PHPMailer\PHPMailer::ENCODING_BASE64, 
        string $type = '', 
        string $disposition = 'attachment'): self
    {
         $this->mailer->addAttachment($path, $name, $encoding, $type, $disposition);    
         return $this;
    }

    public function send(): bool
    {
        try {
            return $this->mailer->send();
        } catch (\Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
            return false;
        }
    }
}