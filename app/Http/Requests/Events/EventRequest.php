<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $eventId = $this->route('id'); // Para el método edit que recibe el ID

        return [
            'event_name' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
            'description' => [
                'required',
                'string',
                'min:10',
                'max:150'
            ],
            'date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'direction' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
          
            'type_event' => [
                'required',
                'integer',
                'not_in:0',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'event_name.required' => 'El nombre del evento es obligatorio.',
            'event_name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'event_name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'type_event.not_in' => 'Debe seleccionar un tipo de evento válido.',
            
            'description.required' => 'La descripción del evento es obligatoria.',
            'description.min' => 'La descripción debe tener al menos 10 caracteres.',
            'description.max' => 'La descripción no puede exceder los 150 caracteres.',
            
            'date.required' => 'La fecha del evento es obligatoria.',
            'date.date' => 'La fecha debe tener un formato válido.',
            'date.after_or_equal' => 'La fecha del evento no puede ser anterior a hoy.',
            
            'direction.required' => 'La ubicación del evento es obligatoria.',
            'direction.min' => 'La ubicación debe tener al menos 3 caracteres.',
            'direction.max' => 'La ubicación no puede exceder los 255 caracteres.',
            
            'type_event.required' => 'El tipo de evento es obligatorio.',
            'type_event.max' => 'El tipo de evento no puede exceder los 100 caracteres.',
        ];
    }

    /* Atributos personalizados para manejar errores
     */
    public function attributes(): array
    {
        return [
            'event_name' => 'nombre del evento',
            'description' => 'descripción',
            'date' => 'fecha',
            'direction' => 'ubicación',
            /*Validar con Franklin el tipo que es el tipo de evento*/
            'type_event' => 'tipo de evento'
        ];
    }

    /* Validaciones personalizadas
    *
    *Validacion para que no se guarde mas de un evento el mismo dia en la misma ubicacion
    *
    */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validación personalizada: verificar que la fecha no sea más de 1 año en el futuro
            if ($this->date) {
                $eventDate = \Carbon\Carbon::parse($this->date);
                $maxDate = \Carbon\Carbon::now()->addYear();
                
                if ($eventDate->greaterThan($maxDate)) {
                    $validator->errors()->add('date', 'La fecha del evento no puede ser más de 1 año en el futuro.');
                }
            }
            
            // Validación personalizada: no permitir más de un evento el mismo día en el mismo lugar
            if ($this->date && $this->direction) {
                $eventId = $this->route('id'); // Para edición
                
                $existingEvent = \App\Models\Event::where('date', $this->date)
                    ->where('direction', $this->direction)
                    ->when($eventId, function ($query) use ($eventId) {
                        return $query->where('id', '!=', $eventId); // Excluir el evento actual en edición
                    })
                    ->first();
                
                if ($existingEvent) {
                    $validator->errors()->add('direction', 'Ya existe un evento programado para esta fecha en esta ubicación.');
                    $validator->errors()->add('date', 'Ya existe un evento programado para esta fecha en esta ubicación.');
                }
            }
        });
    }
}

