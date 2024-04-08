<?php

namespace Tests\Feature\Api\V1;

use App\Models\Administrateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;

class AuthenticationTest extends TestCase
{
    #[Group('apiv1')]
    public function test_administrateur_login_token_check(): void
    {
        $administrateur = Administrateur::create([
            'email' => 'admin.test@example.com',
            'password' => Hash::make('p@ssw0rd')
        ]);

        $response = $this->post('/api/v1/auth', [
            'email' => 'admin.test@example.com',
            'password' => 'p@ssw0rd',
        ]);

        $response->assertSee('token');
        $administrateur->tokens()->delete();
        $administrateur->delete();
    }
}
