<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAccessID extends Mailable
{
    use Queueable, SerializesModels;

    private $user_result = null;
    private $user_style = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($urec, $style)
    {
        //
        $this->user_result = $urec;
        $this->user_style = $style;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.access_id')
        ->subject('メール送信します');
    }
}
