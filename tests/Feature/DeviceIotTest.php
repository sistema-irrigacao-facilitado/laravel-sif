<?php

namespace Tests\Feature;

use App\Models\AverageData;
use App\Models\DataDevice;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

// Simula o ESP32 (firmware em esp32/) chamando a rota da API.
class DeviceIotTest extends TestCase
{
    use RefreshDatabase;

    private function criarDispositivo(): Device
    {
        $agora = now();
        $plantaId = DB::table('plants')->insertGetId([
            'common_name' => 'Alface', 'scientific_name' => 'Lactuca sativa', 'water_need' => 'high',
            'soil_type' => 'humus', 'humidity_tolerance' => 60, 'temperature_tolerance' => 28,
            'created_at' => $agora, 'updated_at' => $agora,
        ]);
        $bombaId = DB::table('pumps')->insertGetId([
            'model' => 'Bomba 12V', 'flow' => 2.5, 'created_at' => $agora, 'updated_at' => $agora,
        ]);

        $dados = [
            'model' => 'SIF v1', 'numbering' => '00000001', 'mode' => '2',
            'time_on' => json_encode(['1' => ['08:00', '17:30'], '3' => ['06:15']]),
            'period' => '60000', 'status' => 2, 'update_status' => 1,
            'plant_id' => $plantaId, 'pump_id' => $bombaId,
            'created_at' => $agora, 'updated_at' => $agora,
        ];
        $id = DB::table('devices')->insertGetId($dados);
        return Device::find($id);
    }

    private function leitura(array $extra = [])
    {
        // mesmo formato que o firmware manda
        return $this->post('/api/device/write', array_merge([
            'numbering' => '00000001', 'humidity' => '45.5', 'temperature' => '24.0', 'liters_pump' => '1.250',
        ], $extra), ['Accept' => 'application/json']);
    }

    public function test_primeira_leitura_grava_e_devolve_a_configuracao(): void
    {
        $this->criarDispositivo();

        $resposta = $this->leitura();

        $resposta->assertOk()->assertJsonPath('message', 'Dados registrados com sucesso');
        $config = json_decode($resposta->json('update'), true);
        $this->assertSame('2', (string) $config['mode']);
        $this->assertSame('60000', (string) $config['period']);
        $this->assertEquals(60, $config['humidity']);
        $this->assertEquals(2.5, $config['flow']);
        $this->assertSame(['08:00', '17:30'], json_decode($config['time_on'], true)['1']);

        $this->assertSame(1, DataDevice::count());
        $this->assertSame(1, AverageData::count());
        $this->assertSame(0, (int) Device::first()->update_status);
    }

    public function test_segunda_leitura_soma_no_mesmo_dia_e_nao_reenvia_configuracao(): void
    {
        $this->criarDispositivo();
        $this->leitura();

        $resposta = $this->leitura(['humidity' => '50.5', 'liters_pump' => '0.750']);

        $resposta->assertOk()->assertJsonMissingPath('update');
        $this->assertSame(2, DataDevice::count());
        $media = AverageData::first();
        $this->assertSame(1, AverageData::count());
        $this->assertEqualsWithDelta(48.0, $media->average_humidity, 0.01);
        $this->assertEqualsWithDelta(2.0, $media->average_liters, 0.01);
        $this->assertSame($media->id, DataDevice::latest('id')->first()->average_data_id);
    }

    public function test_configuracao_volta_a_ser_enviada_quando_muda(): void
    {
        $device = $this->criarDispositivo();
        $this->leitura();

        $device->refresh();
        $device->update_status = 1;
        $device->save();

        $this->leitura()->assertOk()->assertJsonStructure(['message', 'update']);
    }

    public function test_dispositivo_desconhecido_devolve_404(): void
    {
        $this->leitura(['numbering' => '99999999'])->assertNotFound();
    }

    public function test_leitura_incompleta_devolve_422(): void
    {
        $this->criarDispositivo();
        $this->post('/api/device/write', ['numbering' => '00000001'], ['Accept' => 'application/json'])
            ->assertStatus(422);
    }
}
