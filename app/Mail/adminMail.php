<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class adminMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $name;
    public $email;
    public $msg;
    public $subject;
    public $from;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $msg, $subject)
    {
        $this->name = $name;
        $this->email = $email;
        $this->msg = $msg;
        $this->subject = $subject;
        // $this->from = $from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('precodafavela@gmail.com')
        ->subject($this->subject)
        ->view('admin.mail.forgot', [
            'name' => $this->name,
            'email' => $this->email,
            'msg' => $this->msg
        ]);
        
    }
}

