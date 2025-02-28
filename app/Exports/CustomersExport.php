<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{

    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Customer::with([
            'quotations' => function ($query) {
                $query->orderBy('id', 'desc');
            },
            'quotations.contract.post_form.comunication_channel',
            'quotations.contract.post_form.study_place',
            'quotations.contract.post_form.marketing_source',
            'quotations.contract.post_form.hire_factor',
            'quotations.contract.post_form.contract_mode',
            'quotations.contract.post_form.academic_situation',
            'quotations.contract.post_form.professional_status',
            'quotations.contract.post_form.participation',
            'province'
        ])
            ->whereNotNull('password')
            ->whereHas('quotations.contract', function ($q) {
                $q->where('registration_date', 'like', '%' . date($this->date) . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($customer) {
                $quotation = $customer->quotations->first();
                $contract = optional($quotation)->contract;
                $postForm = optional($contract)->post_form;

                return [
                    'Fecha de Registro del Contrato' => optional($contract)->registration_date ?? 'N/A',
                    'Código' => optional($contract)->code ?? 'N/A',
                    'Nombre' => $customer->name,
                    'Correo Electrónico' => $customer->email,
                    'DNI' => $customer->dni,
                    'Sexo' => $customer->gender,
                    'Fecha de nacimiento' => $customer->birth_date ?? 'N/A',
                    'Celular' => $customer->cell,
                    'Ciudad de Residencia' => optional($customer->province)->name ?? 'N/A',
                    'Universidad' => $customer->university,
                    'Carrera' => $customer->career,
                    'Tipo de Tesis' => optional($contract)->thesis_type_id ?? 'N/A',
                    'Grado' => optional($contract)->thesis_degree_id ?? 'N/A',
                    'Monto contratado' => optional($quotation)->amount ?? 'N/A',
                    'Canal de comunicación preferido' => optional($postForm)->comunication_channel->name ?? 'N/A',
                    'Cuenta con lugar de estudio' => optional($postForm)->study_place->name ?? 'N/A',
                    '¿Cómo te enteraste de nuestros servicios?' => optional($postForm)->marketing_source->name ?? 'N/A',
                    '¿Cuál fue el factor principal que te llevó a contratar nuestros servicios?' => optional($postForm)->hire_factor->name ?? 'N/A',
                    '¿Cómo realizaste la contratación de nuestros servicios?' => optional($postForm)->contract_mode->name ?? 'N/A',
                    '¿Cuál es tu situación académica actual?' => optional($postForm)->academic_situation->name ?? 'N/A',
                    'Estado profesional' => optional($postForm)->professional_status->name ?? 'N/A',
                    '¿Qué tanto deseas participar en la elaboración de tu tesis?' => optional($postForm)->participation->name ?? 'N/A'
                ];
            });
    }


    /**
     * Define los encabezados del archivo.
     */
    public function headings(): array
    {
        return [
            'Fecha de Registro del Contrato',
            'Código',
            'Nombre',
            'Correo Electrónico',
            'DNI',
            'Sexo',
            'Fecha de Nacimiento',
            'Celular',
            'Ciudad de Residencia',
            'Universidad',
            'Carrera',
            'Tipo de tesis',
            'Grado',
            'Monto contratado',
            'Canal de comunicación preferido',
            'Cuenta con lugar de estudio',
            '¿Cómo te enteraste de nuestros servicios?',
            '¿Cuál fue el factor principal que te llevó a contratar nuestros servicios?',
            '¿Cómo realizaste la contratación de nuestros servicios?',
            '¿Cuál es tu situación académica actual?',
            'Estado profesional',
            '¿Qué tanto deseas participar en la elaboración de tu tesis?'
        ];
    }
}
