<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller{
    
    function  __construct(){
        parent::__construct();

        $this->load->model('M_usersegmentation');
    }
    
    function send(){
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');
        
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        
        // SMTP configuration
        /*$mail->isSMTP();
        $mail->Host     = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'user@example.com';
        $mail->Password = '********';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;*/

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = "tls"; // sets the prefix to the servier
        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Port = 587; // set the SMTP port for the GMAIL server
        $mail->Username = "info.digitalmediacenter@gmail.com"; // GMAIL username
        $mail->Password = "digitalmedia123"; // GMAIL password

        $data = $this->M_usersegmentation->select_by_id($_POST['id']);
        $pass = $this->M_usersegmentation->encrypt_decrypt('decrypt', $data->password_);
        
        $mail->setFrom('info.digitalmediacenter@gmail.com', 'digitalmedia.mx');
        $mail->addReplyTo('info.digitalmediacenter@gmail.com', 'digitalmedia.mx');
        
        // Add a recipient
        if(!empty($data->email)&&!is_null($data->email)){
            $arrayaddAddress = explode(";",$data->email);
            foreach($arrayaddAddress as $element){
                if(!empty($element)&&!is_null($element)){
                    $mail->addAddress($element);
                }
            }            
        }      

        if(!empty($data->emailcc)&&!is_null($data->emailcc)){
            $arrayaddCC = explode(";",$data->emailcc);
            foreach($arrayaddCC as $element){
                if(!empty($element)&&!is_null($element)){
                    $mail->addCC($element);
                }
            } 
        }

        if(!empty($data->emailbcc)&&!is_null($data->emailbcc)){           
            $arrayaddBCC = explode(";",$data->emailbcc);
            foreach($arrayaddBCC as $element){       
                if(!empty($element)&&!is_null($element)){         
                    $mail->addBCC($element);
                }
            }
        }
        
        // Email subject
        $mail->Subject = 'Acoount Segmentation - By Company - '.$data->namecompany;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = "<h1>Account Segmentation</h1>
                        <p>User Name: ".$data->username."</p>".
                        "<p>PassWord: ".$pass."</p>".
                        "<br>".
                        "Access Link: <a href=\"/catalogo3\">Click to Access link</a>".
                        "<br>".
                        "<br>".
                        "<a href=\"http://www.digitalmedia.mx/\"><img src=\"data:image/jpeg;base64,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\" alt=\"Digital Media\"></a>";
        
        $mail->MsgHTML($mailContent);
        if(!$mail->send()){
                $out['status'] = '';
				$out['msg'] = show_succ_msg('Error - Message could not be sent., '.'Mailer Error: ' . $mail->ErrorInfo, '20px'); 
        }else{
                $result = $this->M_usersegmentation->update(
                        array(
                                "sendemail"=>(int)$data->sendemail+1,
                                "datemaillast"=>date("Y-m-d H:i:s")
                            ), array(
                                        "user_id"=>$data->user_id
                                    )
                );
                $out['status'] = '';
				$out['msg'] = show_succ_msg('Success - Message has been sent', '20px'); 
        }
        echo json_encode($out);
    }
    
}