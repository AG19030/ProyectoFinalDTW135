<?php

namespace App\Http\Controllers\Backend\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function create(Request $request)
    {
        //Crear un Event Request para validar los datos en backend
        try {
            DB::beginTransaction();
            Event::create([
                'name' => $request->event_name,
                'description' => $request->description,
                'date' => $request->date,
                'location' => $request->location,
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

    public function edit($id, Request $request)
    {
        //Crear un Event Request para validar los datos en backend
        try {
            DB::beginTransaction();
            $event = Event::find($id);

            $event->name = $request->event_name;
            $event->description = $request->description;
            $event->date = $request->date;
            $event->location = $request->location;
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
        return view('backend.events.show', compact('id'));
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
            return ['status' => 200, 'message' => 'Evento actualizado correctamente.'];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => 500, 'message' => 'Error al actualizar el evento.'];
        }
    }
}
