<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\OrdenTecnica;

class OrdenEstadoActualizado extends Notification
{
    use Queueable;

    protected $orden;

    public function __construct(OrdenTecnica $orden)
    {
        $this->orden = $orden;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Estado de su orden técnica actualizado')
                    ->line("La orden técnica #{$this->orden->id_orden} ha sido {$this->orden->estado}.")
                    ->action('Ver orden', url(route('ordenes.show', $this->orden->id_orden)))
                    ->line('Gracias por usar CGA OIL Industries.');
    }

    public function toArray($notifiable)
    {
        return [
            'orden_id' => $this->orden->id_orden,
            'estado' => $this->orden->estado,
            'mensaje' => "Su orden técnica #{$this->orden->id_orden} fue {$this->orden->estado}."
        ];
    }
}

