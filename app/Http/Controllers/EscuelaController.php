<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use Illuminate\Http\Request;

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
}
