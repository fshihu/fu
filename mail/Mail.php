<?php
/**
 * User: fu
 * Date: 12-7-29
 * Time: 下午4:48
 */
require_once dirname(__FILE__).'/PHPMailer.php';

class Mail
{

    /**
     * @param string $to 收件人名称
     * @param string $fromName 来自谁的邮件，公司名称
     * @param string $fromEmail 发送邮件的地址
     * @param string $subject
     * @param string $body
     * @return bool|mixed
     */
    public static function sendMsg($to,$fromName,$subject = "",$body = "",$attachment = array(),$isclear = true)
    {

        $mail = new PHPMailer(); //new一个PHPMailer对象出来
       // $body = preg_replace("[\]", '', $body); //对邮件内容进行必要的过滤
        $mail->CharSet = 'UTF-8';
        $mail->SMTPAuth = 'true';
        $mail->Host = 'smtp.aliyun.com';
        $mail->Port = '25';
        $mail->Username = 'sender123@aliyun.com';
        $mail->Password = 'fa123456f';
        $mail->SMTPDebug = '1';
        $mail->IsSMTP(); // 设定使用SMTP服务
       // $this->SMTPSecure = "ssl"; // 安全协议
       // $this->AddReplyTo("邮件回复地址,如admin#jiucool.com #换成@", "邮件回复人的名称");
        $mail->Subject = $subject;
        $mail->AltBody = "To view the message, please use an HTML compatible email viewer! - From home.huo.com"; // optional, comment out and test
        $mail->SetFrom($mail->Username, $fromName);
        $mail->Debugoutput = 'error_log';
        $mail->MsgHTML($body);
        $mail->AddAddress($to, strstr($to, '@', true),$isclear );
        if(!empty($attachment)){
            $mail -> AddAttachment($attachment[0],$attachment[1]);//附件的路径和附件名称
        }
        //$this-> FromEmail = $fromEmail;
        //$this->AddAttachment("images/phpmailer.gif");      // attachment
        //$this->AddAttachment("images/phpmailer_mini.gif"); // attachment
        if (!$mail->Send()) {
            return $mail->ErrorInfo;
        }else {
            return true;
        }

    }
}
