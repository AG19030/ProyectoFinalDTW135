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
                'type_id' => $request->type_id,
                'created_by' => Auth::user()->usuario
            ]);
            DB::commit();
            return ['success' => 99];
        } catch (\Exception $e) {
            Log::info('error ' . $e->getMessage());
            DB::rollback();
            return ['success' => 99];
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
            $event->type_id = $request->type_id;
            $event->updated_by = Auth::user()->usuario;
            $event->save();
            DB::commit();
            return ['success' => 99];
         
        } catch (\Exception $e) {
            Log::info('error ' . $e->getMessage());
            DB::rollback();
            return ['success' => 99];
        }
    }
    // Mostrar detalles de un evento
    public function show($id)
    {
        $event = Event::findOrFail($id);// Cambiado para pasar el objeto $event
        return view('backend.events.show', compact('event'));
    }
    // Obtener y visualizar todos los eventos
    public function list()
    {
    $events = Event::all(); 
    return view('backend.admin.events.list', compact('events'));
    }
     // Eliminar evento
     public function destroy($id)
     {
         try {
             $event = Event::findOrFail($id);
             $event->delete();
             return redirect()->route('events.list')->with('success', 'Evento eliminado correctamente.');
         } catch (\Exception $e) {
             Log::error('Error al eliminar evento: ' . $e->getMessage());
             return redirect()->route('events.list')->with('error', 'Hubo un problema al eliminar el evento.');
         }
     }
 }
