<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index()
    {
        // $teacher = Teacher::included()->findOrFail(2); //prueba para un solo docente
        // $teachers = Teacher::included()->get(); //traer todos con relaciones
        // $teachers = Teacher::included()->filter()->sort()->get(); //con filtros y orden
        $teachers = Teacher::included()->filter()->sort()->getOrPaginate(); //con todo
        // $teachers = Teacher::included()->filter()->get(); //solo con filtros

        // $teachers = Teacher::all(); //traer todo sin nada
        // $teachers = Teacher::with(['area', 'trainingCenter'])->get(); //con relaciones específicas

        return response()->json($teachers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validar los datos que llegan
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'area_id' => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
        ]);

        $teacher = Teacher::create($request->all()); //crear el docente

        return response()->json($teacher);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show($id) //mostrar un docente por id
    {
        $teacher = Teacher::findOrFail($id); //buscar por id
        // $teacher = Teacher::with(['area', 'trainingCenter'])->findOrFail($id); //con relaciones
        // $teacher = Teacher::with(['courses'])->findOrFail($id); //solo con cursos
        return response()->json($teacher);
    }

    public function update(Request $request, Teacher $teacher)
    {
        //validar los datos
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'area_id' => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
        ]);

        $teacher->update($request->all()); //actualizar

        return $teacher;
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete(); //eliminar
        return $teacher;
    }
}
