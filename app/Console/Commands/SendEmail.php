<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Quotation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $customers = Customer::where('property_fill', 0)->get();

        Mail::raw('Estimado usuario se le recuerda porfavor completar los datos necesario, para empezar el proceso de Investigación', function ($message) use ($customers) {
            foreach ($customers as $customer) {
                $message->to($customer->email)
                    ->subject('Notificación Inbestiga Tesis');
            }
        });

        $this->info('Correo enviado exitosamente!');
    }
}
