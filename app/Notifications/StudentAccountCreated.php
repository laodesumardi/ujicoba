<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentAccountCreated extends Notification
{
    use Queueable;

    protected $studentName;
    protected $username;
    protected $password;
    protected $loginUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct($studentName, $username, $password, $loginUrl = null)
    {
        $this->studentName = $studentName;
        $this->username = $username;
        $this->password = $password;
        $this->loginUrl = $loginUrl ?? url('/login');
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
        return (new MailMessage)
                    ->subject('Selamat! Akun Siswa Anda Telah Dibuat - SMP Negeri 01 Namrole')
                    ->greeting('Selamat ' . $this->studentName . '!')
                    ->line('Pendaftaran PPDB Anda telah **DITERIMA** dan akun siswa telah dibuat secara otomatis.')
                    ->line('Berikut adalah informasi login Anda:')
                    ->line('**Username:** ' . $this->username)
                    ->line('**Password:** ' . $this->password)
                    ->line('**URL Login:** ' . $this->loginUrl)
                    ->line('')
                    ->line('**Penting:**')
                    ->line('• Simpan informasi login ini dengan baik')
                    ->line('• Anda dapat mengubah password setelah login pertama kali')
                    ->line('• Jika mengalami kesulitan, hubungi admin sekolah')
                    ->action('Login Sekarang', $this->loginUrl)
                    ->line('Selamat bergabung di SMP Negeri 01 Namrole!')
                    ->salutation('Terima kasih, Tim Admin SMP Negeri 01 Namrole');
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
