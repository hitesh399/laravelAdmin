<?php

namespace App\Services;

use Cache;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Illuminate\Contracts\View\Factory;
use Swift_Mailer;
use Illuminate\Contracts\Events\Dispatcher;

class Mailer extends \Illuminate\Mail\Mailer
{
	protected $email_template;

	public function __construct(Factory $views, Swift_Mailer $swift, Dispatcher $events = null)
    {
        parent::__construct($views,$swift,$events);        
        
    }

     /**
     * Render the given view.
     *
     * @param  string  $view
     * @param  array  $data
     * @return string
     */
    protected function renderView($view, $data)
    {
    	
        if(!$this->email_template)
        	return parent::renderView($view, $data);

        $body = $this->email_template['body'];
        $subject = $this->email_template['subject'];
        $this->email_template['subject'] = $this->renderString($subject,$data);
        return $this->email_template['body'] = $this->renderString($body,$data);
    }

     /**
     * Parse the given view name or array.
     *
     * @param  string|array  $view
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function parseView($view)
    {
        if(is_array($view)){

            return parent::parseView($view);
        }

        $is_tmplt = preg_match('/^[0-9\-\_a-z\.]+$/i',$view);
        $this->email_template = $is_tmplt?Cache::get('email_template.'.$view):null;

    	if(!$this->email_template)
    	{
        	return parent::parseView($view);

    	}else{

            return [$view, null, null];
    	}

        throw new InvalidArgumentException('Invalid view.');
    }

    /**
     * compile given string
     * @param  [type] $string [description]
     * @param  [type] $data   [description]
     * @return [type]         [description]
     */
    protected function renderString($string, $data)
    {
        $php = $string;
        $obLevel = ob_get_level();
        ob_start();
        extract($data, EXTR_SKIP);

        try {
            eval('?' . '>' . $php);
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw $e;
        } catch (Throwable $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw new FatalThrowableError($e);
        }

        return ob_get_clean();
    }

     /**
     * Create a new message instance.
     *
     * @return \Illuminate\Mail\Message
     */
    protected function createMessage()
    {
        $message = new \Illuminate\Mail\Message($this->swift->createMessage('message'));

        // If a global from address has been specified we will set it on every message
        // instances so the developer does not have to repeat themselves every time
        // they create a new message. We will just go ahead and push the address.
        if (! empty($this->from['address'])) {
            $message->from($this->from['address'], $this->from['name']);
        }

        // When a global reply address was specified we will set this on every message
        // instances so the developer does not have to repeat themselves every time
        // they create a new message. We will just go ahead and push the address.
        if (! empty($this->replyTo['address'])) {
            $message->replyTo($this->replyTo['address'], $this->replyTo['name']);
        }

        if(!empty($this->email_template)){
            
            # add Email in cc
            $cc = $this->email_template['cc'];
            
            if(!empty($cc)){

                foreach (explode(',',$cc) as $email) {

                    $message->cc($email);
                }
            }

            # add email in bcc
            $bcc = $this->email_template['bcc'];
            
            if(!empty($bcc)){
            
                foreach (explode(',',$bcc) as $email) {

                    $message->bcc($email);
                }
            }

            # Add Mail Subject
            $subject = $this->email_template['subject'];
            $message->subject($subject);
    
        }

        return $message;
    }
}