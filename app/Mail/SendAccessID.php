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

        //
        $this->from = array([
            "address" => "info@ecm-training.com",
            "name" => "コミュニケーションスタイル診断"
        ]);

        //
        $this->to = array([
            "address" => $urec->email,
            "name" => $urec->name
        ]);

        //
        $this->subject = "[コミュニケーションスタイル診断] <".$urec->name.">様の診断結果へのアクセス情報をお送りいたします。";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('mails.access_id')
        ->with(["urec"=>$this->user_result, "style"=>$this->user_style]);
    }
}
