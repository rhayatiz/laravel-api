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
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'nom' => 'required|max:255',
                'prenom' => 'required|max:255',
                'statut' => ['required', new Enum(ProfilStatut::class)]
            ];
        } elseif ($method == 'PATCH') {
            return [
                'nom' => 'sometimes|max:255',
                'prenom' => 'sometimes|max:255',
                'statut' => ['sometimes', new Enum(ProfilStatut::class)]
            ];
        }
    }
}
