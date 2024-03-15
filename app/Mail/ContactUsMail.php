<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $formData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($formData)
    {
        $this->formData = $formData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromAddress = Config::get('mail.from.address');
        $fromName = Config::get('mail.from.name');

        return $this->from($fromAddress, $fromName)
            ->subject('客戶來信：聯絡我們表單提交')
            ->view('back.emails.contact_us')
            ->with('formData', $this->formData);
    }
}
