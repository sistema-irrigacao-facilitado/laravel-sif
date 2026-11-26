<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\AverageData;
use App\Models\DataDevice;
use App\Models\Device;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeviceIotController extends Controller
{
    /**
     * Recebe as leituras do ESP32 (POST /api/device/write).
     *
     * Grava a leitura, atualiza a média do dia e, se a configuração do dispositivo
     * mudou na plataforma, devolve a configuração nova no campo "update".
     */
    public function write(Request $request)
    {
        $request->validate([
            "numbering" => "required|string|size:8",
            "liters_pump" => "required|numeric",
            "humidity" => "required|numeric",
            "temperature" => "required|numeric",
        ]);

        $device = Device::where('numbering', $request->numbering)->first();

        if (!$device) {
            return response()->json([
                "message" => "Dispositivo não encontrado",
            ], 404);
        }

        try {
            // uma linha de médias por dispositivo por dia
            $average = AverageData::where('device_id', $device->id)
                ->whereDate('created_at', now()->toDateString())
                ->latest()
                ->first();

            if (!$average) {
                $average = new AverageData([
                    'device_id' => $device->id,
                    'humidity' => [],
                    'temperature' => [],
                    'liters' => [],
                    'data' => [],
                ]);
            }

            $average->addHumidityData((float) $request->humidity);
            $average->addTemperatureData((float) $request->temperature);
            $average->addLiters((float) $request->liters_pump);
            $average->addDate(now()->toDateString());

            $average->average_humidity = $average->calculateAverageHumidity();
            $average->average_temperature = $average->calculateAverageTemperature();
            $average->average_liters = $average->calculateTotalLiters();
            $average->save();

            DataDevice::create([
                "humidity" => $request->humidity,
                "temperature" => $request->temperature,
                "liters_pump" => $request->liters_pump,
                "device_id" => $device->id,
                "average_data_id" => $average->id,
            ]);

            $resposta = ["message" => "Dados registrados com sucesso"];

            // a configuração só é enviada quando mudou, e depois volta a ficar "em dia"
            if ($device->update_status == 1) {
                $resposta["update"] = $device->updateIoT($device);
                $device->update_status = 0;
                $device->save();
            }

            return response()->json($resposta);
        } catch (Exception $e) {
            Log::error('Erro ao gravar leitura do dispositivo', [
                'numbering' => $request->numbering,
                'erro' => $e->getMessage(),
            ]);

            return response()->json([
                "message" => "Ocorreu um erro ao processar a solicitação",
            ], 500);
        }
    }
}
