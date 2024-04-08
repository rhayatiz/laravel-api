<?php

namespace Tests\Feature\Api\V1;

use App\Models\Administrateur;
use App\Models\Profil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;

class ProfilTest extends TestCase
{
    #[Group('apiv1')]
    public function test_get_one_profil(): void
    {
        $profil = Profil::factory()
                        ->count(1)
                        ->create()
                        ->first();

        $response = $this->get("/api/v1/profil/$profil->id");
        $this->assertJson($response->content(), $profil);
        $profil->delete();
    }

    /**
     * vérifier qu'un utilisateur non authentifié n'aie pas accès au champ statut
     */
    #[Group('apiv1')]
    public function test_get_one_profil_as_unauthenticated_check_statut_invisible(): void
    {
        $profil = Profil::factory()
                        ->count(1)
                        ->create()
                        ->first();

        $response = $this->get("/api/v1/profil/$profil->id");
        $response->assertDontSee('statut');
        $profil->delete();
    }

    /**
     * vérifier qu'un administrateur aie accès au champ statut
     */
    #[Group('apiv1')]
    public function test_get_one_profil_as_administrateur_check_statut_visible(): void
    {
        $profil = Profil::factory()
                    ->count(1)
                    ->create()
                    ->first();

        $administrateur = Administrateur::create([
            'email' => 'admin.test@example.com',
            'password' => Hash::make('p@ssw0rd')
        ]);
        $token = $administrateur->createToken('token')->plainTextToken;

        $response = $this->withHeader(
            "Authorization","Bearer $token"
        )->get("/api/v1/profil/$profil->id");

        $response->assertSee('statut');

        $administrateur->tokens()->delete();
        $administrateur->delete();
        $profil->delete();
    }

    #[Group('apiv1')]
    public function test_create_profil_check_unauthenticated_is_unauthorized(): void
    {
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->withHeader('Accept', 'application/json')
        ->post('/api/v1/profil', [
            'nom' => 'dupont',
            'prenom' => 'toto',
            'statut' => 'en attente',
            'image' => $file
        ]);

        $response->assertStatus(401);
    }

    #[Group('apiv1')]
    public function test_create_profil_authenticated(): void
    {
        $administrateur = Administrateur::create([
            'email' => 'admin.test@example.com',
            'password' => Hash::make('p@ssw0rd')
        ]);
        $token = $administrateur->createToken('token')->plainTextToken;
    
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->withHeader('Authorization', "Bearer $token")
        ->post('/api/v1/profil', [
            'nom' => 'dupont',
            'prenom' => 'toto',
            'statut' => 'en attente',
            'image' => $file
        ]);

        $response->assertStatus(200);
        $administrateur->tokens()->delete();
        $administrateur->delete();
    }

    #[Group('apiv1')]
    public function test_update_profil_check_unauthicated_is_unauthorized(): void
    {
        $profil = Profil::factory(1)
                        ->create()
                        ->first();
    
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->withHeader('Accept', "application/json")
        ->post("/api/v1/profil/$profil->id", [
            'nom' => 'dupont',
            'prenom' => 'toto',
            'statut' => 'en attente',
            'image' => $file
        ]);

        $response->assertStatus(401);
    }

    #[Group('apiv1')]
    public function test_update_profil_authenticated(): void
    {
        $profil = Profil::factory(1)
                    ->create()
                    ->first();
        $id = $profil->id;

        $administrateur = Administrateur::create([
            'email' => 'admin.test@example.com',
            'password' => Hash::make('p@ssw0rd')
        ]);
        $token = $administrateur->createToken('token')->plainTextToken;
    
        $this->withHeader('Authorization', "Bearer $token")
        ->post("/api/v1/profil/$id", [
            'nom' => 'test changement nom',
        ]);


        $newProfil = Profil::find($id);
        $this->assertTrue($newProfil->nom == 'test changement nom');
        $administrateur->tokens()->delete();
        $administrateur->delete();
        // $newProfil->delete();
    }

    #[Group('apiv1')]
    public function test_delete_profil_unauthicated_is_unauthorized(): void
    {
        $profil = Profil::factory(1)
                        ->create()
                        ->first();
    
        $response = $this->withHeader('Accept', "application/json")
        ->delete("/api/v1/profil/$profil->id");

        $response->assertStatus(401);
    }

    #[Group('apiv1')]
    public function test_delete_profil_authenticated(): void
    {
        $profil = Profil::factory(1)
                    ->create()
                    ->first();
        $id = $profil->id;

        $administrateur = Administrateur::create([
            'email' => 'admin.test@example.com',
            'password' => Hash::make('p@ssw0rd')
        ]);
        $token = $administrateur->createToken('token')->plainTextToken;
    
        $this->withHeader('Authorization', "Bearer $token")
        ->delete("/api/v1/profil/$id");


        $profil = Profil::find($id);
        $this->assertTrue($profil == null);
        $administrateur->tokens()->delete();
        $administrateur->delete();
    }
}


