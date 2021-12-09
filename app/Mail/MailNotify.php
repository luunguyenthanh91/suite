<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
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
       return $this->from('system@suite.alphacep.co.jp' , 'AlphaCep事務局')
            ->cc(['support@alphacep.co.jp'])
           ->view('mails.mail-notify')
           ->subject('[フリーランス通訳案件] ' . $this->data['address_pd']. ' (' . $this->data['ngay_pd'] . ')');
   }
}