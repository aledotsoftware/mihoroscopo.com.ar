<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    // Si deseas especificar el nombre de la tabla en caso de que no siga la convención
    protected $table = 'pages';

    // Si deseas especificar la clave primaria en caso de que no sea 'id'
    protected $primaryKey = 'id';

    // Si la clave primaria no es autoincremental, desactiva la propiedad incrementing
    public $incrementing = true;

    // Si la clave primaria no es de tipo entero, desactiva la propiedad $keyType
    protected $keyType = 'int';

    // Si deseas usar timestamps, asegúrate de que esta propiedad esté habilitada (por defecto está habilitada)
    public $timestamps = true;

    // Definir los atributos que son asignables en masa
    protected $fillable = [
        'title',
        'slug',
        'content',
    ];

    // Puedes definir relaciones con otros modelos aquí si es necesario
}
