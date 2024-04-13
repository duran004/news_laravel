<?php

namespace App\Jobs;

use App\Mail\MailSender;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class TestQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public function __construct(
        public string $mail_adress
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Mail::to($this->mail_adress)->send(new MailSender());
    }
}