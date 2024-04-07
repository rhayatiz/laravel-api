<?php

namespace App\Http\Requests;

use App\Enums\ProfilStatut;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreProfilRequest extends FormRequest
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
        return [
            'nom' => 'required|max:255',
            'prenom' => 'required|max:255',
            'image' => 'required|image|max:2048',
            'statut' => [new Enum(ProfilStatut::class)],
        ];
    }

    public function messages() 
    {
        return [
            'image.required' => 'le champ image est obligatoire',
            'image' => 'La taille du fichier ne doit pas dépasser 2MB'
        ];
    }
}
