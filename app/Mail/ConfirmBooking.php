<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use app\Models\Customr ;
use app\Models\Room ;
use app\Models\Centre ;
use app\Models\Booking ;

class ConfirmBooking extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    // public $centre ;
    // public $customr ;
    public $room, $resrvation;
    public function __construct(Room $room , Booking $resrvation)
    {
    //    $this->centre = $centre ;
    //    $this->customr = $customr ;
       $this->room = $room ;
       $this->resrvation = $resrvation ;
       
    }
   
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm Booking',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            markdown: 'emails.ConfirmBooking',
            // with : [
            //     'Aurl' => route('check', ['id' => $resrvation->id , 'check'=> 1 ]) ,
            //     // 'Rurl' => route('check'),
                
            // ]
        );
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
