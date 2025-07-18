<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // Campos que se pueden llenar masivamente
    protected $fillable = ['course_number', 'day', 'area_id', 'training_center_id'];

    // Listas de lo que se puede incluir, filtrar y ordenar
    protected $allowIncluded = ['area', 'trainingCenter', 'teachers', 'apprentices'];
    protected $allowFilter = ['id', 'course_number', 'day', 'area_id', 'training_center_id'];
    protected $allowSort = ['id', 'course_number', 'day'];

    // Relación con el área
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // Relación con el centro de formación
    public function trainingCenter()
    {
        return $this->belongsTo(TrainingCenter::class);
    }

    // Relación con los docentes (muchos a muchos)
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'course_teacher');
    }

    // Relación con los aprendices
    public function apprentices()
    {
        return $this->hasMany(Apprentice::class);
    }

    // Para incluir relaciones en la consulta
    public function scopeIncluded($query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) return;
        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);
        foreach ($relations as $key => $rel) {
            if (!$allowIncluded->contains($rel)) unset($relations[$key]);
        }
        $query->with($relations);
    }

    // Para filtrar por campos específicos
    public function scopeFilter($query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) return;
        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);
        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE', "%$value%");
            }
        }
    }

    // Para ordenar los resultados
    public function scopeSort($query)
    {
        if (empty($this->allowSort) || empty(request('sort'))) return;
        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);
        foreach ($sortFields as $sortField) {
            $direccion = 'asc';
            if (substr($sortField, 0, 1) == '-') {
                $direccion = 'desc';
                $sortField = substr($sortField, 1);
            }
            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direccion);
            }
        }
    }

    // Para paginar o traer todo
    public function scopeGetOrPaginate($query)
    {
        if (request('perPage')) {
            $porPagina = intval(request('perPage'));
            if ($porPagina) return $query->paginate($porPagina);
        }
        return $query->get();
    }
}
