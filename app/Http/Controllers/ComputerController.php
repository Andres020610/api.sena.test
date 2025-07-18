<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    // Listar todos los registros
    public function index()
    {
        return \App\Models\Computer::included()
            ->filter()
            ->sort()
            ->getOrPaginate();
    }

    // Guardar un registro
    public function store(Request $request)
    {
        // esto es para poder Validar los campos antes de guardar
        $request->validate([
            'number' => 'required|max:255',
            'brand' => 'required|max:255',
        ]);

        $computer = Computer::create($request->all());
        return response()->json($computer, 201);
    }

    // Mostrar un registro por id
    public function show($id)
    {
        $computer = Computer::findOrFail($id);
        return response()->json($computer);
    }
}
