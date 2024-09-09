<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\TimeSlots;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeSlotsController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Cátalogo de horarios';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $horarios = TimeSlots::all()->sortBy('hour')->sortBy('minute');
        $horarios = $horarios->map(function ($horario) {
            $horario->hour = str_pad($horario->hour, 2, '0', STR_PAD_LEFT);
            $horario->minute = str_pad($horario->minute, 2, '0', STR_PAD_LEFT);
            return $horario;
        });

        return view('academia.admin.time-slots', compact('title', 'name', 'rol', 'links', 'photo', 'horarios'));

    }

    public function addCatalogoHorario(Request $request)
    {
        $title = 'Agregar horario';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        return view('academia.admin.add-time-slot', compact('title', 'name', 'rol', 'links', 'photo'));
    }

    public function saveCatalogoHorario(Request $request): RedirectResponse
    {
        //custom message
        $messages = [
            'hour.required' => 'La hora es requerida',
            'hour.integer' => 'La hora debe ser un número entero',
            'hour.max' => 'La hora debe ser menor o igual a 23',
            'minute.required' => 'El minuto es requerido',
            'minute.integer' => 'El minuto debe ser un número entero',
            'minute.max' => 'El minuto debe ser menor o igual a 59',

        ];

        $request->validate([
            'hour' => 'required|integer|max:23',
            'minute' => 'required|integer||max:59',
        ], $messages);

        // Comprobar la unicidad de la combinación de 'hour' y 'minute'
        $exists = DB::table('time_slots')
            ->where('hour', $request->hour)
            ->where('minute', $request->minute)
            ->exists();

        if ($exists) {
            $hour = str_pad($request->hour, 2, '0', STR_PAD_LEFT);
            $minute = str_pad($request->minute, 2, '0', STR_PAD_LEFT);
            return back()->withErrors(['hour_minute' => 'El horario ' . $hour . ':' . $minute . ' ya existe']);
        }

        $horario = new TimeSlots();
        $horario->hour = $request->hour;
        $horario->minute = $request->minute;
        $horario->save();

        return redirect()->route('admin.horarios-disponibles');
    }

    public function deleteTimeSlot( $id): RedirectResponse
    {
        TimeSlots::destroy($id);
        return redirect()->route('admin.horarios-disponibles');
    }
}
