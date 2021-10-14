<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;


class MailController extends Controller
{
    
    private function mailTemplate($template,$data)
    {
        $contents = view('emails.'.$template, $data)->render();
        return $contents;
    }

    public function sendMail($params){
        $mail = new PHPMailer(true);
        $subject = $params['Subject'];
        $toAddress = "itextsm@gmail.com";
        $mailTemplate = $this->mailTemplate($params["template"],$params);
        $fromAddress = "itextsm@gmail.com";
        $replyTo = "info@iisysgroup.com";
       
        try{
            $mail->isSMTP();
            $mail->SMTPDebug = 0;       // Enable verbose debug output | Production Server = 0
            $mail->CharSet = 'utf-8';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            
            $mail->Host = "smtp.gmail.com"; //gmail has host > smtp.gmail.com
            $mail->Port = "587"; //gmail has port > 587 . without double quotes
            $mail->Username = "itextsm@gmail.com"; //your username. actually your email
            $mail->Password = "48398378"; // your password. your mail password
           
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom($fromAddress, "Itex Transaction Monitoring System"); 
            $mail->Subject = $subject;
            $mail->MsgHTML($mailTemplate);
            $mail->addAddress($toAddress , 'Emmanuel Paul');
            // Add more addresses
            // $recipients = array(
            //     'anthony.idigbe@iisysgroup.com' => "Anthony Idigbe",
            //     'godwin.aleke@iisysgroup.com' => 'Godwin Aleke',
            //     'sanusi.segun@iisysgroup.com' => 'Sanusi Segun',
            //     'michel.kalavanda@iisysgroup.com' => 'Michel Kalavanda'
            // );

            // foreach($recipients as $email => $name)
            // {
            //     $mail->AddCC($email, $name);
            // }

            $mail->addReplyTo($replyTo, "info@iisysgroup.com");

            if ($mail->send()) {
                
                return 'Message has been sent';
            } else {
                
                return 'Message not sent';
            }
        }catch(Exception $e){
            \Log::info($e->getMessage());
            return $e->getMessage();
        }
       
    }

}