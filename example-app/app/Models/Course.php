<?php



namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Course extends Model
{
    use HasFactory; // Necesario para crear datos falsos luego

    // 👇 ESTO ES OBLIGATORIO para arreglar el error MassAssignmentException
    protected $fillable = ['name', 'description'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
// Añade esto dentro de la clase
