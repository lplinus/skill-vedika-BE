<?php

namespace App\Mail;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FooterEnrollmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Enrollment $enrollment;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    public function build()
    {
        return $this
            ->subject('New Course Lead Received')
            ->view('emails.new-lead') // 👈 THIS MUST MATCH
            ->with([
                'enrollment' => $this->enrollment,
            ]);
    }
}
