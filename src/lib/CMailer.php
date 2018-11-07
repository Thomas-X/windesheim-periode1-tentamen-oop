<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 02/10/18
 * Time: 11:29
 */

namespace Qui\lib;

/*
 * Since PHP's mail function is a pain to setup (cross platform compatibility is worthless). It seemed to me like a good idea to
 * use some of my python skills and make this a simple wrapper around a python file.
 * Does not support attachments at this moment. Could be added if needed.
 * */

use phpDocumentor\Parser\Exception;
use Qui\lib\facades\Util;

class CMailer
{
    public const MAIL_DEFAULT = [
        'to' => null,
        'subject' => null,
        'body' => null,
    ];
    private $mail = CMailer::MAIL_DEFAULT;

    public function setupMail()
    {
        $this->mail = CMailer::MAIL_DEFAULT;
        return $this;
    }

    public function to($to)
    {
        $this->mail['to'] = $to;
        return $this;
    }

    public function subject($subject)
    {
        $this->mail['subject'] = $subject;
        return $this;
    }

    public function body($body)
    {
        $this->mail['body'] = $body;
        return $this;
    }

     /**
     * @return bool
     * @throws Exception
     */
    /**
     * @return bool
     * @throws Exception
     * sends a cURL request to a raspberry pi running a node web server listening for POST requests that then in turn runs a python script to send an email
     */
    public function send()
    {
        if (!$this->mail['to'] || !$this->mail['body'] || !$this->mail['subject']) {
            throw new Exception('Invalid email to be sent, missing data');
        }
        shell_exec("curl -X POST \
  http://185.47.135.138:3000/email \
  -H 'content-type: application/json' \
  -d '{
	\"superSecretKey\": \"{$_ENV['SUPER_SECRET_EMAIL_KEY']}\",
	\"to\": \"{$this->mail['to']}\",
	\"body\": \"{$this->mail['body']}\",
	\"title\": \"{$this->mail['subject']}\"
}'");
        return true;
    }
}
