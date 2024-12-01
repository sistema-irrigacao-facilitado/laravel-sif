<?php

namespace Tests\Unit;

use App\Models\AverageData;
use App\Models\Device;

use Tests\TestCase;

class AverageDataTest extends TestCase
{


    /** @test */
    public function it_can_create_average_data_with_random_data()
    {
        // Cria um dispositivo e um colaborador para os relacionamentos
        $device = Device::factory()->create();

        // Cria dados aleatórios para AverageData
        $averageData = AverageData::factory()->create([
            'device_id' => $device->id,

        ]);

        // Verifica se o AverageData foi criado corretamente
        $this->assertDatabaseHas('average_data', [
            'id' => $averageData->id,
            'device_id' => $device->id,
        ]);

        // Verifica se os dados de humidade, temperatura e litros são do tipo JSON
        $this->assertJson($averageData->humidity);
        $this->assertJson($averageData->temperature);
        $this->assertJson($averageData->liters);
        $this->assertJson($averageData->data);

        // Verifica se os valores de média não são nulos
        $this->assertNotNull($averageData->average_humidity);
        $this->assertNotNull($averageData->average_temperature);
        $this->assertNotNull($averageData->average_liters);
    }
}
