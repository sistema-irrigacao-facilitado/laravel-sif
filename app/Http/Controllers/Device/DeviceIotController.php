<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\AverageData;
use App\Models\DataDevice;
use App\Models\Device;
use Exception;
use Illuminate\Http\Request;

class DeviceIotController extends Controller
{
     public function write(Request $request)
    {
        try {
            $request->validate([
                "numbering" => "required|string|size:8",
                "liters_pump" => "required|numeric",
                "humidity" => "required|numeric",
                "temperature" => "required|numeric",
            ]);

            $device = Device::where('numbering', $request->numbering);

            $dataDevice = DataDevice::create([
                "humidity" => $request->humidity,
                "temperature" => $request->temperature,
                "liters_pump" => $request->liters_pump,
                "device_id" => $device->id,
            ]);

            $average = AverageData::where('device_id', $device->id)
                ->orderBy('created_at', 'desc')
                ->first();

            $currentDate = $dataDevice->created_at->toDateString();
            $lastDate = null;

            if ($average) {
                $dataDates = json_decode($average->data, true) ?? [];
                $lastDate = end($dataDates);

                if ($lastDate === $currentDate) {
                    $average->addHumidityData($request->humidity);
                    $average->addTemperatureData($request->temperature);
                    $average->addLiters($request->liters_pump);
                    $average->addDate($currentDate);

                    $average->save();

                    $dataDevice->average_id = $average->id;
                    $dataDevice->save();
                } else {
                    $averageHumidity = $average->calculateAverageHumidity();
                    $averageTemperature = $average->calculateAverageTemperature();
                    $totalLiters = $average->calculateTotalLiters();

                    $average->average_humidity = $averageHumidity;
                    $average->average_temperature = $averageTemperature;
                    $average->average_liters = $totalLiters;

                    $average->save();

                    $newAverage = AverageData::create([
                        'device_id' => $device->id,
                        'humidity' => json_encode([$request->humidity]),
                        'temperature' => json_encode([$request->temperature]),
                        'data' => json_encode([$currentDate]),
                    ]);

                    $dataDevice->average_id = $newAverage->id;
                    $dataDevice->save();
                }
            } else {
                $newAverage = AverageData::create([
                    'device_id' => $device->id,
                    'humidity' => json_encode([$request->humidity]),
                    'temperature' => json_encode([$request->temperature]),
                    'liters' => json_encode([$request->liters_pump]),
                    'data' => json_encode([$currentDate]),
                ]);

                $dataDevice->average_id = $newAverage->id;
                $dataDevice->save();
            }

            if ($device->update_status == 1) {
                $up = $device->updateIoT($device);

                return response()->json([
                    "message" => "Dados registrados com sucesso",
                    "update" => $up
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "message" => "Ocorreu um erro ao processar a solicitação",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
}
