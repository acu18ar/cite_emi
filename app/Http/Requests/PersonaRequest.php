<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class PersonaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if ($request->id) {
            return [
                'Nombres' => 'required|regex:/(^[A-Za-z ]+$)+/|max:50',
                'ApellidoPaterno' => 'required|max:80',
                'ApellidoMaterno' => 'nullable|max:80',
                'Grado' => 'max:25',
                'Cargo' => 'max:100',
                'CI' => 'max:999999999',
                'UnidadAcademica' => 'required',
                'Especialidad' => 'required',
                'TipoPersona' => 'required',
                'Rol' => 'required',
                'email' => 'required|email',
            ];
        } else {
            return [
                'Nombres' => 'required|regex:/(^[A-Za-z ]+$)+/|max:50',
                'ApellidoPaterno' => 'required|alpha|max:50',
                'ApellidoMaterno' => 'alpha|max:50',
                'Grado' => 'max:10',
                'Cargo' => 'max:100',
                'CI' => 'max:999999999|unique:Persona',
                'UnidadAcademica' => 'required',
                'Especialidad' => 'required',
                'TipoPersona' => 'required',
                'Rol' => 'required',
                'email' => 'required|email|unique:Persona',
                'FirmaDigitalizada' => 'required',
            ];
        }
    }
}
