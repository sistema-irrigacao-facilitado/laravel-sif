<?php

namespace Tests\Feature;

use App\Models\DataDevice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataDeviceTest extends TestCase
{
    // Não utiliza o RefreshDatabase
    public function test_can_create_multiple_data_devices(): void
    {
        // Cria 20 registros com um loop
        foreach (range(1, 20) as $index) {
            DataDevice::factory()->create();
        }

        // Verifica se 20 registros foram criados
        $this->assertEquals(20, DataDevice::count());
    }
}
