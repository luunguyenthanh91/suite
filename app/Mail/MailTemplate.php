<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTemplate extends Mailable
{
   use Queueable, SerializesModels;

   public $data;
   /**
    * Create a new data instance.
    *
    * @return void
    */

   public function __construct($data)
   {
       $this->data = $data;
   }

   /**
    * Build the message.
    *
    * @return $this
    */
   public function build()
   {
       return $this->from('support@alphacep.co.jp' , 'AlphaCep事務局')
            ->cc([ $this->data['mail_cc'] ])
           ->view('mails.mail-template')
           ->subject($this->data['title']);
   }
}