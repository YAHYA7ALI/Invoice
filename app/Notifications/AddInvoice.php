<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class AddInvoice extends Notification
{
    use Queueable;
    private $Invoice ;
    
    public function __construct(Invoice $Invoice)
    {
        $this->Invoice = $Invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }
    public function toDatabase($notifiable)
    {
        return
        [
            'id'=> $this->Invoice->id,
            'title'=>'تم اضافة فاتورة جديد بواسطة :',
            'user'=> Auth::user()->name,
        ];
    }
}
