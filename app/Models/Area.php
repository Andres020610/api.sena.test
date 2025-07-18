<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Course;

class Area extends Model
{
    // Campos que se pueden llenar masivamente
    protected $fillable = ['name'];

    // Listas de lo que se puede incluir, filtrar y ordenar
    protected $allowIncluded = ['teachers', 'courses'];
    protected $allowFilter = ['id', 'name'];
    protected $allowSort = ['id', 'name'];

    // Relación con los docentes
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    // Relación con los cursos
    public function courses()
    {
        return $this->hasMany(Course::class);
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
