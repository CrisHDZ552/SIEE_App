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

     public function show(Archivo $archivo)
    {
        // Obtener la carpeta de la escuela en public/archivos
        $archivosPath = public_path('archivos');

        // Buscar la carpeta de la escuela
        $escuelaCarpeta = (string)$archivo->escuela_id;
        $rutaCarpeta = $archivosPath . '/' . $escuelaCarpeta;

        if (!File::isDirectory($rutaCarpeta)) {
            return redirect('/')->with('error', 'Carpeta de escuela no encontrada');
        }

        // Obtener el contenido de la carpeta
        $rutaCarpeta = $archivosPath . '/' . $escuelaCarpeta;
        $contenido = [];

        if (File::isDirectory($rutaCarpeta)) {
            // Obtener tanto archivos como directorios
            $items = File::files($rutaCarpeta);
            $subdirectorios = File::directories($rutaCarpeta);

            foreach ($items as $item) {
                $contenido[] = [
                    'nombre' => basename($item),
                    'ruta' => 'archivos/' . $escuelaCarpeta . '/' . basename($item),
                    'tipo' => 'file'
                ];
            }

            foreach ($subdirectorios as $subdirectorio) {
                $contenido[] = [
                    'nombre' => basename($subdirectorio),
                    'ruta' => 'archivos/' . $escuelaCarpeta . '/' . basename($subdirectorio),
                    'tipo' => 'dir'
                ];
            }
        }

        return view('Archivos.showA', compact('archivo', 'contenido'));
    }

    public function showCarpeta(\App\Models\Escuela $escuela, $carpeta)
    {
        $archivosPath = public_path('archivos');
        $numeroCarpeta = (string)$escuela->numero_escuela;
        $rutaCarpeta = $archivosPath . '/' . $numeroCarpeta . '/' . $carpeta;

        if (!File::isDirectory($rutaCarpeta)) {
            return redirect()->route('escuelas.show', $escuela->id)->with('error', 'Carpeta no encontrada');
        }

        $contenido = [];
        $items = File::files($rutaCarpeta);
        $subdirectorios = File::directories($rutaCarpeta);

        foreach ($items as $item) {
            $contenido[] = [
                'nombre' => basename($item),
                'ruta'   => 'archivos/' . $numeroCarpeta . '/' . $carpeta . '/' . basename($item),
                'tipo'   => 'file'
            ];
        }

        foreach ($subdirectorios as $subdirectorio) {
            $contenido[] = [
                'nombre' => basename($subdirectorio),
                'ruta'   => 'archivos/' . $numeroCarpeta . '/' . $carpeta . '/' . basename($subdirectorio),
                'tipo'   => 'dir'
            ];
        }

        // Creamos un objeto simple para la vista (nombre de la carpeta y escuela)
        $archivo = (object)[
            'id'             => null,
            'nombre_carpeta' => $carpeta,
            'contenido'      => $escuela->numero_escuela,
            'escuela_id'     => $escuela->id,
            'escuela'        => $escuela,
        ];

        return view('Archivos.showA', compact('archivo', 'contenido', 'escuela', 'carpeta'));
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