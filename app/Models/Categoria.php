<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $primaryKey = 'idCategoria';
    public $timestamps = false; 

    protected $fillable = [
        'nombre'
    ];
    
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'idCategoria');
    }
}