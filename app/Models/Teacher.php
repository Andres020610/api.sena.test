<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Area;
use App\Models\TrainingCenter;
use App\Models\Course;

class Teacher extends Model
{
    protected $fillable = ['name', 'email', 'area_id', 'training_center_id']; //campos que se pueden llenar

    //listas de lo que se puede hacer
    protected $allowIncluded = ['area', 'trainingCenter', 'courses']; //relaciones que se pueden incluir
    protected $allowFilter = ['id', 'name', 'email', 'area_id', 'training_center_id'];
    protected $allowSort = ['id', 'name', 'email'];

    //relaciones
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function trainingCenter()
    {
        return $this->belongsTo(TrainingCenter::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_teacher');
    }

    //scope para incluir relaciones
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) { //verificar si hay algo para incluir
            return;
        }

        // $test = request('included'); //prueba para ver qué llega

        $relations = explode(',', request('included')); //separar las relaciones por coma

        // return $relations; //prueba para ver el array

        $allowIncluded = collect($this->allowIncluded); //convertir a colección

        foreach ($relations as $key => $relationship) { //recorrer las relaciones

            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]); //quitar las que no están permitidas
            }
        }

        // return $relations; //prueba para ver qué queda

        $query->with($relations); //ejecutar la consulta con las relaciones
    }

    //scope para filtrar
    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');

        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {

            if ($allowFilter->contains($filter)) {

                $query->where($filter, 'LIKE', '%' . $value . '%'); //buscar que contenga el texto
            }
        }
    }

    //scope para ordenar
    public function scopeSort(Builder $query)
    {
        if (empty($this->allowSort) || empty(request('sort'))) {
            return;
        }

        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

        foreach ($sortFields as $sortField) {

            $direction = 'asc';

            if(substr($sortField, 0,1)=='-'){ //si empieza con menos es descendente
                $direction = 'desc';
                $sortField = substr($sortField,1); //quitar el menos
            }
            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction); //ordenar
            }
        }
        //ejemplo: http://api.sena.test/v1/teachers?sort=name
    }

    //scope para paginar o traer todo
    public function scopeGetOrPaginate(Builder $query)
    {
        if (request('perPage')) {
            $perPage = intval(request('perPage')); //convertir a número

            if($perPage){ //si es mayor a 0
                return $query->paginate($perPage); //paginación
            }
        }
        return $query->get(); //traer todo si no hay paginación
        //ejemplo: http://api.sena.test/v1/teachers?perPage=5
    }
}
