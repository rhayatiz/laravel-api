<?php

namespace App\Http\Requests;

use App\Enums\ProfilStatut;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $method = $this->method();

        // if ($method == 'PUT') {
        //     return [
        //         'nom' => 'required|max:255',
        //         'prenom' => 'required|max:255',
        //         'image' => 'required|image|max:2048',
        //         'statut' => ['required', new Enum(ProfilStatut::class)]
        //     ];
        // } elseif ($method == 'PATCH') { 
            return [
                'nom' => 'required_without_all:prenom,image,statut|max:255',
                'prenom' => 'required_without_all:nom,image,statut|max:255',
                'image' => 'required_without_all:nom,prenom,statut|image|max:2048',
                'statut' => ['required_without_all:nom,prenom,image', new Enum(ProfilStatut::class)]
            ];
        // }
    }

    public function messages() 
    {
        return [
            'image.required' => 'Le champ image est obligatoire',
            'image' => 'La taille du fichier ne doit pas dépasser 2MB'
        ];
    }
}
