<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una aplicación de prueba.
 *
 * Este modelo puede ser utilizado para gestionar funcionalidades 
 * específicas dentro del sistema relacionadas con pruebas.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único de la aplicación de prueba.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class TestApp extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = []; // Define aquí los atributos que son asignables en masa, si es necesario.
}