<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EscuelaController extends Controller
{
    public function index()
    {
        // Obtener todas las escuelas iniciales
        $escuelas = Escuela::all();
        return view('welcome', compact('escuelas'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $filter = $request->input('filter');

        $dbQuery = Escuela::query();

        if ($query) {
            if ($filter === 'ctt') {
                $dbQuery->where('ctt', 'LIKE', '%' . $query . '%');
            } elseif ($filter === 'numero_escuela') {
                $dbQuery->where('numero_escuela', 'LIKE', '%' . $query . '%');
            } else {
                $dbQuery->where(function($q) use ($query) {
                    $q->where('ctt', 'LIKE', '%' . $query . '%')
                      ->orWhere('numero_escuela', 'LIKE', '%' . $query . '%');
                });
            }
        }

        $escuelas = $dbQuery->get();

        return response()->json($escuelas);
    }

    public function CrearCarpetasEscuelas()
    {
        return view('Escuelas.Crear');
    }

    public function ValidarCarpetasEscuelas(Request $request)
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

        return redirect('/');
    }
}
