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

    // Muestra la tabla de eventos del sistema
    public function eventTable(){
        $events = Event::orderBy('id', 'ASC')->get();
        return view('backend.admin.events.table.eventtable', compact('events'));
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
    public function show($id)
    {
        return view('backend.events.show', compact('id'));
    }
    public function destroy($id)
    {
        // Logic to delete the event
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
