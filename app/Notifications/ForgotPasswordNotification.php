<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ForgotPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private string $url)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        /*return (new MailMessage)
            ->greeting('Olá, '.$notifiable->firstName.'!')
            ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta..')
            ->action('Reset Password', $this->url)
            ->line('Este link de redefinição de senha expirará em 60 minutos.')
            ->line('Se você não solicitou a redefinição de senha, nenhuma ação adicional será necessária.')
            ->line('Obrigado!')
            ->salutation('Volte Sempre')*/

        return (new MailMessage)
            ->view('email.reset-password', ['url' => $this->url, 'user' => $notifiable])
            ->from('vinipasini@hotmail.com', 'Vincius')
            ->subject('Alterar Senha');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
