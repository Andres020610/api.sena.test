<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apprentice extends Model
{
    protected $fillable = ['name', 'email', 'cell_number', 'course_id', 'computer_id'];

    // Listas blancas para controlar qué relaciones, filtros y ordenamientos se pueden usar
    protected $allowIncluded = ['course', 'computer'];
    protected $allowFilter = ['id', 'name', 'email', 'cell_number', 'course_id', 'computer_id'];
    protected $allowSort = ['id', 'name', 'email', 'cell_number'];

    // Relación con el computador asignado al aprendiz
    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }

    // Relación con el curso al que pertenece el aprendiz
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Scope para incluir relaciones permitidas
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

    // Scope para filtrar resultados por columnas permitidas
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

    // Scope para ordenar resultados por columnas permitidas
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

    // Scope para paginar o traer todos los resultados
    public function scopeGetOrPaginate($query)
    {
        if (request('perPage')) {
            $porPagina = intval(request('perPage'));
            if ($porPagina) return $query->paginate($porPagina);
        }
        return $query->get();
    }
}
