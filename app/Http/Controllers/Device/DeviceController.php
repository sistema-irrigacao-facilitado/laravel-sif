<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Http\Traits\Filterable;
use App\Models\AverageData;
use App\Models\DataDevice;
use App\Models\Device;
use App\Models\Plant;
use App\Models\Pump;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function list(Request $request)
    {
        try {
            $query = Device::query();
            $filters = [
                'id' => '=',
                'model' => function ($query, $value) {
                    $query->where('model', 'like', '%' . $value . '%');
                },
                'numbering' => function ($query, $value) {
                    $query->where('numbering', 'like', '%' . $value . '%');
                },
                'created_at_from' => function ($query, $value) {
                    $query->whereDate('created_at', '>=', $value);
                },
                'created_at_to' => function ($query, $value) {
                    $query->whereDate('created_at', '<=', $value);
                },
                'status' => '=',
            ];
            $this->applyFilters($query, $request->session(), 'device', $filters);
            $collection = $query->orderBy('id')->paginate(30);
            return view('admin.devices.list', ['collection' => $collection]);
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar este dispositivo.');
        }
    }

    public function new()
    {
        return view('admin.devices.new');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'model' => 'required|string',
                'numbering' => 'required|string|size:8',
            ]);

            $device = new Device([
                'model' => $request->model,
                'numbering' => $request->numbering,
            ]);

            $device->save();

            return redirect()->route('admin.devices')->with('success', 'Dispositivo criado com sucesso');
        } catch (ValidationException $e) {
            // Captura erro de validação e retorna os erros com old input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erro ao validar os dados. Verifique os campos informados.');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar este dispositivo.');
        }
    }

    public function edit($id)
    {
        $device = Device::findOrFail($id);
        return view('admin.devices.edit', compact('device'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'model' => 'required|string',
                'numbering' => 'required|string|size:8',
            ]);

            $device = Device::findOrFail($id);
            $device->update([
                'model' => $request->model,
                'numbering' => $request->numbering,
            ]);

            return redirect()->route('admin.devices')->with('success', 'Dispositivo atualizado com sucesso');
        } catch (ValidationException $e) {
            // Captura erro de validação e retorna os erros com old input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erro ao validar os dados. Verifique os campos informados.');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar este dispositivo.');
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $device = Device::findOrFail($id);
            $device->status = $status;
            $device->save();

            return redirect()->route('admin.devices')->with('success', 'Status do dispositivo atualizado com sucesso');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Erro ao atualizar o status do dispositivo.');
        }
    }

    public function delete($id)
    {
        try {
            $device = Device::findOrFail($id);
            $device->delete();

            return redirect()->route('admin.devices')->with('success', 'Dispositivo excluído com sucesso');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Erro ao excluir o dispositivo.');
        }
    }

    public function add()
    {
        $user = User::find(getAuthUser()->id);
        if ($user) {
            if ($user->status == 2) {
                return view('user.device.add');
            }
        }
    }

    public function upUserId(Request $request)
    {
        $user = User::find(getAuthUser()->id);
        $request->validate(["numbering" => "required|string|min:8|max:8"]);
        $device = Device::where('numbering', $request->numbering)->first();
        if ($user) {
            if ($user->status == 2) {
                if (!$device) {

                    return redirect()->route('user.device.add');
                }
                if ($device->status != 1 && $device->status != 9) {
                    return redirect()->route('user.device.add');
                }
                $device->user_id = $user->id;
                $device->status = 2;
                $device->save();
                return redirect()->route('dashboard');
            }
            return redirect()->route('logout');
        }
        return redirect()->route('logout');
    }




    public function report(Request $request, $id)
    {
        $user = User::find(getAuthUser()->id);
        $device = Device::findOrFail($id);

        if ($user) {
            if ($user->status == 2) {

                if ($request->perMode == 2) {
                    $query = AverageData::query();
                    $fields = ['average_humidity', 'average_temperature', 'average_liters', 'created_at'];
                } else {
                    $query = DataDevice::query();
                    $fields = ['humidity', 'temperature', 'liters_pump', 'created_at'];
                }

                $userTimezone = 'America/Sao_Paulo'; // Exemplo, você pode obter dinamicamente do banco de dados
                $hr = now()->setTimezone($userTimezone)->subHour()->format('Y-m-d H:i:s');

                if ($request->from) {
                    $query = $query->where('created_at', '>=', $request->from);
                } else {
                    $query = $query->where('created_at', '>=', $hr);
                }


                $collection = $query->where('device_id', $id)->get();

                $values = extractValuesFromCollection($collection, $fields);

                return view(
                    'user.device.report',
                    [
                        'device' => $device,
                        'collection' => $collection,
                        'values' => $values,
                        'perMode' => $request->perMode,
                    ]
                );
            }
            return redirect()->route('logout');
        }

        // Redirecionar para logout se o usuário não for encontrado
        return redirect()->route('logout');
    }


    use Filterable;
    public function config($id)
    {
        $user = User::find(getAuthUser()->id);
        $device = Device::findOrFail($id)->first();
        $dataDevice = DataDevice::where('device_id', $id)->orderBy('created_at', 'desc')->first();
        $plant = Plant::find($device->plant_id);
        $pump = Pump::find($device->pump_id);

        if ($pump) {
            $decodedImage = base64_decode($pump->image);
            $imageDataUri = 'data:image/jpeg;base64,' . base64_encode($decodedImage);
            $pump->image_url = $imageDataUri;
        }
        if ($plant) {
            $decodedImage = base64_decode($plant->image);
            $imageDataUri = 'data:image/jpeg;base64,' . base64_encode($decodedImage);
            $plant->image_url = $imageDataUri;
        }

        if ($user) {
            if ($user->status == 2) {
                if (!$device) {
                    return redirect()->route('dashboard');
                }
                if (!$device) {
                    return redirect()->route('dashboard');
                }
                if ($device->status != 2) {
                    return redirect()->route('dashboard');
                }

                return view('user.device.config', [
                    'device' => $device,
                    'dataDevice' => $dataDevice,
                    'plant' => $plant,
                    'pump' => $pump,
                ]);
            }

            return redirect()->route('logout');
        }

        return redirect()->route('logout');
    }

    public function modeUpdate(Request $request, $id)
    {
        $user = User::find(getAuthUser()->id);
        $device = Device::findOrFail($id)->first();


        if ($user) {
            if ($user->status == 2) {
                if (!$device) {
                    return redirect()->route('dashboard');
                }
                if ($device->status != 2) {
                    return redirect()->route('dashboard');
                }
                if ($device->mode == 2) {
                    $request->validate(
                        ["mode" => "required|int|max:2"],
                        ['time_on' => "nullable|time"]
                    );
                    if ($request->time_on) {
                        if ($request->time_on != $device->time_on) {
                            $device->time_on = $request->time_on;
                            $update_status = 1;
                        }
                    }
                    if ($request->period) {
                        $period = periodUnFormat($request->period);
                        if ($period != $device->period) {
                            $device->period = $period;
                            $update_status = 1;
                        }
                    }
                }
                if ($device->mode != $request->mode) {
                    $device->mode = $request->mode;
                    $update_status = 1;
                }

                if ($update_status == 1) {
                    $device->update_status = $update_status;
                    $device->save();
                }

                return redirect()->route('user.device.config', $id);
            }

            return redirect()->route('logout');
        }

        return redirect()->route('logout');
    }

    public function unlink(Request $request)
    {
        $user = User::find(getAuthUser()->id);
        $device = Device::findOrFail($request->id)->first();


        if ($user) {
            if ($user->status == 2) {
                if (!$device) {
                    return redirect()->route('dashboard');
                }
                if ($device->status != 2) {
                    return redirect()->route('dashboard');
                }


                $device->status = 9;
                $device->save();

                return redirect()->route('dashboard');
            }

            return redirect()->route('logout');
        }

        return redirect()->route('logout');
    }

}
