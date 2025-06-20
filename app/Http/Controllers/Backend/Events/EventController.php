<?php

namespace App\Http\Controllers\Backend\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Events\EventRequest;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        return view('backend.admin.events.events');
    }


    // Muestra la tabla de eventos del sistema
    public function eventTable(){
        $events = Event::orderBy('id', 'ASC')->get();
        return view('backend.admin.events.table.eventtable', compact('events'));
    }

    public function create(EventRequest $request)
    {
        //Crear un Event Request para validar los datos en backend
        // Los datos ya están validados automáticamente por EventRequest
        try {
            DB::beginTransaction();
            Event::create([
                'event_name' => $request->event_name,
                'description' => $request->description,
                'date' => $request->date,
                'direction' => $request->direction,
                'type_event' => $request->type_event,
                'created_by' => Auth::user()->usuario
            ]);
            DB::commit();
            return ['status' => 200, 'message' => 'Evento creado correctamente.'];
        } catch (\Exception $e) {
            Log::info('error ' . $e->getMessage());
            DB::rollback();
            return ['status' => 500, 'message' => 'Error al crear el evento.'];
        }
    }

    public function edit($id, EventRequest $request)
    {
        //Crear un Event Request para validar los datos en backend
        try {
            DB::beginTransaction();
            $event = Event::find($id);

            // Verificar que el evento existe
            if (!$event) {
                return ['status' => 404, 'message' => 'Evento no encontrado.'];
            }
            // Los datos ya están validados automáticamente por EventRequest
            $event->event_name = $request->event_name;
            $event->description = $request->description;
            $event->date = $request->date;
            $event->direction = $request->direction;
            $event->type_event = $request->type_event;
            $event->updated_by = Auth::user()->usuario;
            $event->save();
            DB::commit();
            return ['status' => 200, 'message' => 'Evento actualizado correctamente.'];
        } catch (\Exception $e) {
            Log::info('error ' . $e->getMessage());
            DB::rollback();
            return ['status' => 500, 'message' => 'Error al actualizar el evento.'];
        }
    }
    public function show($id)
    {
        if($event = Event::where('id', $id)->first()){

            return ['success' => 200,
                'message' => 'Evento encontrado.',
                'id' => $event->id,
                'event_name' => $event->event_name,
                'description' => $event->description,
                'date' => $event->date,
                'direction' => $event->direction,
                'type_event' => $event->type_event];
        }else{
            return ['status' => 404, 'message' => 'Evento no encontrado.'];
        }
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $event = Event::find($id);

            if (!$event) {
                return ['status' => 404, 'message' => 'Evento no encontrado.'];
            }
            $event->delete();
            DB::commit();
            return ['status' => 200, 'message' => 'Evento eliminado correctamente.'];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => 500, 'message' => 'Error al eliminar el evento.'];
        }
    }
}
