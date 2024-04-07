<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfilRequest;
use App\Http\Requests\UpdateProfilRequest;
use App\Http\Resources\V1\ProfilCollection;
use App\Http\Resources\V1\ProfilResource;
use App\Models\Profil;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProfilCollection(Profil::where('statut', 'actif')->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfilRequest $request)
    {
        $profilData = $request->all();
        if ($request->hasFile('image')) {
            $filename = $this->uploadProfilImage($request);
            // $request->merge(['image' => $filename]); //overwriting avec merge() ne fonctionne pas sur les fichiers?
            $profilData['image'] = $filename;
        }
        new ProfilResource(Profil::create($profilData));
    }

    /**
     * Display the specified resource.
     */
    public function show(Profil $profil)
    {
        return new ProfilResource($profil);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfilRequest $request, Profil $profil)
    {

        $profilData = $request->all();
        if ($request->hasFile('image')) {
            $filename = $this->uploadProfilImage($request);
            // $request->merge(['image' => $filename]); //overwriting avec merge() ne fonctionne pas sur les fichiers?
            $profilData['image'] = $filename;
        }

        $profil->update($profilData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profil $profil)
    {
        $profil->delete();
    }


    /**
     * stores profil image and returns filename.extension
     */
    private function uploadProfilImage(FormRequest $request): string
    {
        $file = $request->file('image');
        $filename = $file->hashName();
        $file->store('public/images');
        return $filename;
    }
}
