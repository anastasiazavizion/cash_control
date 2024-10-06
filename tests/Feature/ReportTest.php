<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Traits\SetupTrait;

class ReportTest extends TestCase
{
    use SetupTrait;


    public function testMakePdfReport()
    {
        Notification::fake();

        $password = 'password';
        $user = User::factory()->create([
            'password' => $password
        ]);

        Storage::fake('public');

        $response = $this->actingAs($user)->get(route('report', ['type' => 'pdf']));

        $this->assertEquals(200, $response->status());
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertEquals('attachment; filename=report', $response->headers->get('Content-Disposition'));
    }

    public function testMakeExcelReport()
    {
        Notification::fake();

        $password = 'password';
        $user = User::factory()->create([
            'password' => $password
        ]);

        Storage::fake('public');

        $response = $this->actingAs($user)->get(route('report', ['type' => 'xlsx']));

        $this->assertEquals(200, $response->status());
        $this->assertEquals('application/excel', $response->headers->get('Content-Type'));
        $this->assertEquals('attachment; filename=report', $response->headers->get('Content-Disposition'));
    }
}
