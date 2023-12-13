<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CourseApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($staffApplications)
    {
        //
        $this->staffApplications = $staffApplications; // Store the variable in the class property
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        //subject email
        return new Envelope(
            subject: 'Course Approval Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $staffApplications = $this->staffApplications; // Access the variable passed to the constructor

        return (new Content(
            view: 'admin.newEnroll',
        ))->with(['staffApplications' => $staffApplications]); // Pass it to the view using 'with'
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
