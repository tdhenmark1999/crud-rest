<?php

namespace App\Laravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendEmailVerificationToken extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;
    protected $source;
    protected $name;
    protected $email;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, array $options = [ 'source' => "backend"])
    {
        $this->token = $token;
        $this->source = $options['source'];
        $this->name = isset($options['name']) ? $options['name'] : "user";
        $this->email = isset($options['email']) ? $options['email'] : "[your account's email]";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        switch ($this->source) {
            case 'api':
                return (new MailMessage)
                    ->from(env('MAIL_ADDRESS','noreply@domain.com') )
                    ->subject("[Mentor Me] Validate your account ({$this->email})")
                    ->view(
                        'emails.verify', [
                            'token' => $this->token, 
                            'name'  => $this->name,
                        ]
                    );
                // return (new MailMessage)
                //     ->greeting("Hello {$this->name}!")
                //     ->from("no-reply@thingsilikeapp.com", "Things I Like")
                //     ->subject("Please verify your password reset request on Things I Like")
                //     ->line("A request has been made to reset the password for {$this->email}. Please use the unique code below to reset your password.")
                //     ->line("<b>{$this->token}</b>")
                //     ->salutation('Have a fantastic day! <br> Your Things I Like Team');
            break;
            default:
                return (new MailMessage)
                    ->from(env('MAIL_ADDRESS','noreply@domain.com'))
                    ->subject('Reset Password')
                    ->line('Reset your password by clicking the button below.')
                    ->action('Click Me', route('backoffice.auth.reset_password', [$this->token]));
        }
        
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
