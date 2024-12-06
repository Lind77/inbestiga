<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Customer::with(['quotations' => function ($query) {
            $query->orderBy('id', 'desc');
        }, 'quotations.contract', 'quotations.contract.post_form', 'quotations.contract.post_form.comunication_channel', 'quotations.contract.post_form.study_place', 'quotations.contract.post_form.marketing_source', 'quotations.contract.post_form.hire_factor', 'quotations.contract.post_form.contract_mode', 'quotations.contract.post_form.academic_situation', 'quotations.contract.post_form.professional_status', 'quotations.contract.post_form.participation', 'province'])
            ->where('password', '!=', null)
            ->whereHas('quotations.contract', function ($q) {
                $q->where('registration_date', 'like', '%' . date('Y-m') . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($customer) {
                return [
                    'Fecha de Registro del Contrato' => $customer->quotations->first()->contract->registration_date ?? 'N/A',
                    'Código' => $customer->quotations->first()->contract->code ?? 'N/A',
                    'Nombre' => $customer->name,
                    'Correo Electrónico' => $customer->email,
                    'DNI' => $customer->dni,
                    'Sexo' => $customer->gender,
                    'Fecha de nacimiento' => $customer->birth_date ?? 'N/A',
                    'Celular' => $customer->cell,
                    'Ciudad de Residencia' => $customer->province->name ?? 'N/A',
                    'Universidad' => $customer->university,
                    'Carrera' => $customer->career,
                    'Tipo de Tesis' => $customer->quotations->first()->contract->thesis_type_id,
                    'Grado' => $customer->quotations->first()->contract->thesis_degree_id,
                    'Monto contratado' => $customer->quotations->first()->amount,
                    'Canal de comunicación preferido' => $customer->quotations->first()->contract->post_form->comunication_channel->name,
                    'Cuenta con lugar de estudio' => $customer->quotations->first()->contract->post_form->study_place->name,
                    '¿Cómo te enteraste de nuestros servicios?' => $customer->quotations->first()->contract->post_form->marketing_source->name,
                    '¿Cuál fue el factor principal que te llevó a contratar nuestros servicios?' => $customer->quotations->first()->contract->post_form->hire_factor->name,
                    '¿Cómo realizaste la contratación de nuestros servicios?' => $customer->quotations->first()->contract->post_form->contract_mode->name,
                    '¿Cuál es tu situación académica actual?' => $customer->quotations->first()->contract->post_form->academic_situation->name,
                    'Estado profesional' => $customer->quotations->first()->contract->post_form->professional_status->name,
                    '¿Qué tanto deseas participar en la elaboración de tu tesis?' => $customer->quotations->first()->contract->post_form->participation->name
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
