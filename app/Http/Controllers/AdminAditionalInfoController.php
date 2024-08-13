<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HowFoundUs;
use App\Models\Course;

define("linksAdmin", [
    (object) ['url' => '/admin', 'name' => 'Dashboard', 'icon' => 'home.png'],
    (object) ['url' => '/admin/profesores', 'name' => 'Profesores', 'icon' => 'profesor.png'],
    (object) ['url' => '/admin/info-adicional', 'name' => 'Información adicional', 'icon' => 'info.png'],
]);

class AdminAditionalInfoController extends Controller
{
    /**
     * Display the index.
     */
    public function index()
    {
        $title = 'Información adicional';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = linksAdmin;
        $linksAditionalInfo = [
            (object) ['url' => '/admin/info-adicional/catedras', 'name' => 'Cátedras', 'icon' => 'course.png'],
            (object) ['url' => '/admin/info-adicional/como-nos-encontraste', 'name' => '¿Cómo nos encontraste?', 'icon' => 'search.png'],
        ];
        $items = HowFoundUs::all();
        return view('academia.admin.catalogs', compact('title', 'name', 'rol', 'links', 'linksAditionalInfo'));
    }

    /**
     * Display the "¿Cómo nos encontraste?" index.
     */
    public function comoNosEncontraste() {
        $title = '¿Cómo nos encontraste?';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = linksAdmin;
        $items = HowFoundUs::orderBy('active', 'desc')->orderBy("how", 'asc')->get();
        return view('academia.admin.how-found-us', compact('title', 'name', 'rol', 'links', 'items'));
    }

    /**
     * Display the form to add a new "¿Cómo nos encontraste?".
     */
    public function addComoNosEncontraste() {
        $title = 'Agregar ¿Cómo nos encontraste?';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = linksAdmin;
        return view('academia.admin.add-how-found-us', compact('title', 'name', 'rol', 'links'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveComoNosEncontraste(Request $request) {
        $message = [
            'nombre.unique' => 'El nombre ya existe, prueba con uno diferente.',
        ];
        $request->validate([
            'nombre' => 'unique:how_found_us,how',
        ], $message);
        $item = new HowFoundUs();
        $item->how = $request->nombre;
        $item->save();
        return redirect('/admin/info-adicional/como-nos-encontraste');
    }

    /**
     * Display the form to edit a "¿Cómo nos encontraste?".
     */
    public function editComoNosEncontraste($id) {
        $title = 'Editar ¿Cómo nos encontraste?';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = linksAdmin;
        $item = HowFoundUs::find($id);
        return view('academia.admin.edit-how-found-us', compact('title', 'name', 'rol', 'links', 'item'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function updateComoNosEncontraste(Request $request, $id) {
        $error = DB::table('how_found_us')->where('how', $request->nombre)->where('id', '!=', $id)->get();
        if (count($error) > 0) {
            return redirect()->back()->with('error', 'El nombre ya existe, prueba con uno diferente.');
        }
        $item = HowFoundUs::find($id);
        $item->how = $request->nombre;
        $item->active = $request->active == 'on' ? 1 : 0;
        $item->save();
        return redirect('/admin/info-adicional/como-nos-encontraste');
    }

    /**
     * Display the "Catedrás" index.
     */
    public function catedras() {
        $title = 'Catedrás';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = linksAdmin;
        $items = Course::orderBy('name', 'asc')->get();
        return view('academia.admin.courses', compact('title', 'name', 'rol', 'links', 'items'));
    }

    /**
     * Display the form to add a new "Cátedra".
     */
    public function addCatedra() {
        $title = 'Agregar Cátedra';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = linksAdmin;
        return view('academia.admin.add-course', compact('title', 'name', 'rol', 'links'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveCatedra(Request $request) {
        $message = [
            'nombre.unique' => 'El nombre ya existe, prueba con uno diferente.',
        ];
        $request->validate([
            'nombre' => 'unique:courses,name',
        ], $message);
        $item = new Course();
        $item->name = $request->nombre;
        $item->description = $request->descripcion;
        $item->save();
        return redirect('/admin/info-adicional/catedras');
    }

    /**
     * Display the form to edit a "Cátedra".
     */
    public function editCatedra($id) {
        $title = 'Editar Cátedra';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = linksAdmin;
        $item = Course::find($id);
        return view('academia.admin.edit-course', compact('title', 'name', 'rol', 'links', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCatedra(Request $request, $id) {
        $error = DB::table('courses')->where('name', $request->nombre)->where('id', '!=', $id)->get();
        if (count($error) > 0) {
            return redirect()->back()->with('error', 'El nombre ya existe, prueba con uno diferente.');
        }
        $item = Course::find($id);
        $item->name = $request->nombre;
        $item->description = $request->descripcion;
        $item->save();
        return redirect('/admin/info-adicional/catedras');
    }
}
