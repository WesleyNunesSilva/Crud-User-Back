<?php 

use App\Models\User;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('pode listar usuários com paginação', function () {
    User::factory()->count(5)->create();

    $response = $this->getJson('/api/users');

    $response->assertOk()
             ->assertJsonStructure([
                 'success',
                 'data',
                 'meta',
                 'links',
             ]);
});

it('pode criar um usuário com permissões', function () {
    $permissions = Permission::factory()->count(2)->create();

    $payload = [
        'name' => 'Teste Usuário',
        'email' => 'teste@exemplo.com',
        'phone' => '11999999999',
        'user_type' => 'Administrador',
        'department' => 'TI',
        'permissions' => $permissions->pluck('id')->toArray(),
    ];

    $response = $this->postJson('/api/users', $payload);

    $response->assertCreated()
             ->assertJsonFragment(['email' => 'teste@exemplo.com']);
});

it('pode atualizar um usuário', function () {
    $user = User::factory()->create([
        'email' => 'original3@exemplo.com'
    ]);

    $payload = [
        'name' => 'Nome Atualizado',
        'email' => $user->email,
        'phone' => $user->phone,          
        'user_type' => $user->user_type,  
        'department' => $user->department ,
        'permissions' => [] // Supondo que as permissões 1 e 2 existam,
    ];

    $response = $this->putJson("/api/users/{$user->id}", $payload);

    $response->assertOk()
             ->assertJsonFragment(['name' => 'Nome Atualizado']);
});

it('pode deletar (soft delete) um usuário', function () {
    $user = User::factory()->create();

    $response = $this->deleteJson("/api/users/{$user->id}");

    $response->assertOk();

    $this->assertSoftDeleted('users', ['id' => $user->id]);
});
