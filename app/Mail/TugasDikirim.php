<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class TugasDikirim extends Mailable
{
    use Queueable, SerializesModels;

    public $task;  // Menyimpan data task yang dikirim

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mahasiswa = $this->task->bimbingan->mahasiswaBimbingan;
        return $this->view('emails.tugasdikirim')
            ->with([
                'task' => $this->task,
                'mahasiswa' => $mahasiswa,
            ]);
        // Pastikan Anda memiliki view untuk email ini
    }
}
