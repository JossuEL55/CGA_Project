namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->isMethod('post')) {
            // Creación de orden (solo admin)
            return [
                'cliente_id'    => 'required|exists:clientes,id',
                'planta_id'     => 'required|exists:plantas,id',
                'tecnico_id'    => 'nullable|exists:users,id',
                'observaciones' => 'nullable|string|max:2000',
            ];
        }

        if($this->isMethod('put')) {
            // Actualización (solo observaciones, por técnico)
            return [
                'observaciones' => 'required|string|max:2000',
            ];
        }

        return [];
    }
}
