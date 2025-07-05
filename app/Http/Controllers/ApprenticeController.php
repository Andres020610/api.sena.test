<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use Illuminate\Http\Request;

class ApprenticeController extends Controller
{
    // Listar todos los aprendices
    public function index()
    {
        $apprentices = Apprentice::all();
        return response()->json($apprentices);
    }

    // Guardar un aprendiz
    public function store(Request $request)
    {
        //por si quiero validar los campos antes de guardar
       // $request->validate([
       //     'name' => 'required|max:255',
        //    'email' => 'required|email|max:255',
        //    'cell_number' => 'required|max:20',
        //    'course_id' => 'required|exists:courses,id',
        //    'computer_id' => 'required|exists:computers,id',
      //  ]);
 

        $apprentice = Apprentice::create($request->all());
        return response()->json($apprentice, 201);
    }

    // Mostrar un aprendiz por id
    public function show($id)
    {
        $apprentice = Apprentice::findOrFail($id);
        return response()->json($apprentice);
    }

}
