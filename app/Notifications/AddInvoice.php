<?php

namespace App\Notifications;

use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInvoice extends Notification
{
    use Queueable;
    private $invoice_id;
    private $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice_id, $invoice)
    {
        $this->invoice_id = $invoice_id ;
        $this->invoice = $invoice ;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = 'http://127.0.0.1:8000/InvoicesDetails/'.$this->invoice_id ;
        return (new MailMessage)
                    ->subject('اضافة فاتورة جديدة')
                    ->greeting('Hello!')
                    ->line('تم اضافة فاتورة جديدة')
                    ->action('عرض الفاتورة', url($url))
                    ->line('شكرا لاستخدامك موقعنا');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [

        ];
    }


    public function toDatabase($notifiable)
    {
        return [
            'invoice_id' => $this->invoice->id,
            'title' =>'تم اضافة فاتورة جديدة بواسطة',
            'auth' => Auth::user()->name,
            'amount' => $this->invoice->amount,
            // Additional data you want to store in the notifications table
        ];
    }

/**
 * Get the notification's database type.
 *
 * @return string
 */
    public function databaseType(object $notifiable): string
    {
        return 'new invoice created';
    }
}
