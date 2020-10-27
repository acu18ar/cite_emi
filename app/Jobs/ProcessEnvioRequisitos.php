<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\PersonaEspecialidad;

class ProcessEnvioRequisitos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $personaEspecialidad;
    public $tries = 3;

    public function retryUntil() {
        return now()->addSeconds(120);
    }
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PersonaEspecialidad $personaEspecialidad)
    {
        $this->personaEspecialidad = $personaEspecialidad;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->personaEspecialidad->enviaRequisitosPorCorreo();
    }
}
