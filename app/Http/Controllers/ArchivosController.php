<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ArchivosController extends Controller
{

    public function CrearCarpetasA(\App\Models\Escuela $escuela)
    {
        return view('Archivos.CrearA', compact('escuela'));
    }

    public function ValidarCarpetasA(Request $request, \App\Models\Escuela $escuela)
    {
        $request->validate([     //Validar que los campos no esten vacios y max caracteres
            'nombre_carpeta' => 'required|max:50|unique:archivos,nombre_carpeta',
            'contenido' => 'required|max:50',
        ]);

        $archivo = new Archivo();
        $archivo->nombre_carpeta = $request->nombre_carpeta; //Darle valor al objeto
        $archivo->contenido = $request->contenido;
        //$archivo->user_id = Auth::id();  //Guardar el usuario que creo la carpeta
        $archivo->save();

        // Obtener la carpeta de la escuela en public/archivos
        $archivosPath = public_path('archivos');
        $escuelaCarpeta = (string)$escuela->numero_escuela;
        $rutaCarpeta = $archivosPath . '/' . $escuelaCarpeta;

        if (File::isDirectory($rutaCarpeta)) {
            // Crear la carpeta dentro de la carpeta de la escuela
            $folderName = $archivo->nombre_carpeta;
            $path = public_path('archivos/' . $escuelaCarpeta . '/' . $folderName);
            File::makeDirectory($path, 0755, true, true);
        }

        return redirect()->route('escuelas.show', $escuela->id);
    }
    
    
    //Todavia no se usa todo lo de abajo
    public function CrearArchivosEscuelas()
        {
            return view('Archivos.CrearA');
        }

    public function ValidarArchivosEscuelas(Request $request)
    {
        $request->validate([     //Validar que los campos no esten vacios y max caracteres
            'numero_escuela' => 'required|max:15|unique:escuelas,numero_escuela',
            'ctt' => 'required|max:15',
        ]);

        $escuela = new Escuela();
        $escuela->numero_escuela = $request->numero_escuela; //Darle valor al objeto
        $escuela->ctt = $request->ctt;
        //$escuela->user_id = Auth::id();  //Guardar el usuario que creo la carpeta
        $escuela->save();

        // Crear la carpeta en public/archivos
        $folderName = $escuela->numero_escuela . '_' . uniqid();
        $path = public_path('archivos/' . $folderName);

        File::makeDirectory($path, 0755, true, true);

        return redirect('escuelas.show');
    }
}