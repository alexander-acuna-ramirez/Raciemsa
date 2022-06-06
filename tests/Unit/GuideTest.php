<?php

namespace Tests\Unit;

use App\Models\Guide;
//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\User;

class GuideTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function user_can_access_to_guide_crud()
    {
        $user = User::first();
        $hasUser = $user ? true : false;
        $this->assertTrue($hasUser);
        $response = $this->actingAs($user)->get('/guide');
        $response->assertStatus(200);
    }

    /** @test */
    public function guide_can_be_created()
    {
        $this->withoutExceptionHandling();
        /** Autenticandose */
        $user = User::first();
        $hasUser = $user ? true : false;
        $this->assertTrue($hasUser);
        $response = $this->actingAs($user)->get('/guide/create');
        $response->assertStatus(200);


        $currenCount = Guide::all()->count();
        $response = $this->followingRedirects()->post('/guide', [
            'Codigo_guia_remision' => "GR.402-0016688",
            'Fecha_de_emision' => "2022/06/06",
            'Inicio_traslado' => "2022/06/07",
            'Fin_traslado' => "2022/06/08",
            'Codigo_proveedor' => "2060018016",
        ])->assertStatus(200);
        $this->assertCount($currenCount + 1, Guide::all());
    }



    /** @test */
    public function guide_cannot_be_created_with_a_repeated_code()
    {
        $this->withoutMiddleware();
        $currenCount = Guide::all()->count();
        $response = $this->post('/guide', [
            'Codigo_guia_remision' => "GR.402-0016671",
            'Fecha_de_emision' => "2022/06/06",
            'Inicio_traslado' => "2022/06/07",
            'Fin_traslado' => "2022/06/08",
            'Codigo_proveedor' => "2060018016",
        ]);
        $this->assertCount($currenCount, Guide::all());
    }


    /** @test */
    public function guide_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        /** Autenticandose */
        $user = User::first();
        $hasUser = $user ? true : false;
        $this->assertTrue($hasUser);
        $response = $this->actingAs($user)->get('/guide/create');
        $response->assertStatus(200);

        $cg = "GR.402-0016690";
        $response = $this->followingRedirects()->post('/guide', [
            'Codigo_guia_remision' => $cg,
            'Fecha_de_emision' => "2022/06/06",
            'Inicio_traslado' => "2022/06/07",
            'Fin_traslado' => "2022/06/08",
            'Codigo_proveedor' => "2060018016",
        ])->assertStatus(200);
        $count = Guide::where('Estado', 1)->count();
        $responseDelete = $this->delete('/guide/' + $cg);
        $currentCount = Guide::where('Estado', 1)->get();
        $this->assertCount($count - 1, $currentCount);
    }
}
