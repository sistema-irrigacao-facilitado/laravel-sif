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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getAuth()
    {
        $devices = Device::where('user_id', getAuthUser()->id)->where('status', 2)
            ->with(['dataDevice' => function ($query) {
                $query->orderBy('created_at', 'desc')->first();
            }])
            ->get();
        $user = User::findOrFail(getAuthUser()->id);
        if ($user->status == 2) {
            if ($devices) {
                return view('user.dashboard', ['devices' => $devices, 'user' => $user]);
            }
        }
        return redirect()->route('logout');
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

    public function conf()
    {
        $user = User::find(getAuthUser()->id);
        if ($user) {
            if ($user->status == 2) {
                return view('user.conf', ['user' => $user]);
            }
            return redirect()->route('logout');
        }
        return redirect()->route('logout');
    }

    public function confUpdate(Request $request)
    {
        $user = User::find(getAuthUser()->id);
        if ($user) {
            if ($user->status == 2) {
                // Validação dos dados enviados
                $request->validate([
                    "name" => "required|string|max:200",
                    "lastname" => "required|string|max:200",
                    "telephone" => "required|string|max:15|regex:/^\(\d{2}\)\s\d{5}-\d{4}$/",
                    "cpf" => "required|string|max:15|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/", 
                    "email" => "required|email|max:200"
                ]);

                // Atualizar o usuário com os dados validados
                $user->update([
                    "name" => $request->name,
                    "lastname" => $request->lastname,
                    "telephone" => $request->telephone,
                    "cpf" => $request->cpf,
                    "email" => $request->email
                ]);

                return view('user.conf', ['user' => $user]);
            }
            return redirect()->route('logout');
        }
        return redirect()->route('logout');
    }

    public function password()
    {
        $user = User::find(getAuthUser()->id);
        if ($user) {
            if ($user->status == 2) {
                return view('user.password');
            }
            return redirect()->route('logout');
        }
        return redirect()->route('logout');
    }

    public function passwordUpdate(Request $request)
{
    $user = User::find(getAuthUser()->id);

    if ($user) {
        if ($user->status == 2) {
            // Validação dos dados enviados
            $request->validate([
                "password" => "required|string|min:8|confirmed", // 'confirmed' exige o campo 'password_confirmation'
            ]);

            // Hash da senha antes de salvar
            $password = bcrypt($request->password);

            // Atualizar o usuário com os dados validados
            $user->update([
                "password" => $password,
            ]);

            return view('user.conf', ['user' => $user]);
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


    public function plantSelect(Request $request, $id)
    {
        $user = User::find(getAuthUser()->id);
        $device = Device::findOrFail($id)->first();
        $plant = Plant::where('id', $request->id);


        if ($user) {
            if ($user->status == 2) {
                if (!$device) {
                    return redirect()->route('dashboard');
                }

                if ($device->status != 2) {
                    return redirect()->route('dashboard');
                }
                if (!$plant) {
                    return redirect()->route('dashboard');
                }


                $device->plant_id = $request->id;
                $device->save();

                return redirect()->route('user.device.config', $id);
            }

            return redirect()->route('logout');
        }

        return redirect()->route('logout');
    }

    public function pumpSelect(Request $request, $id)
    {
        $user = User::find(getAuthUser()->id);
        $device = Device::findOrFail($id)->first();
        $pump = Pump::where('id', $request->id);


        if ($user) {
            if ($user->status == 2) {
                if (!$device) {
                    return redirect()->route('dashboard');
                }

                if ($device->status != 2) {
                    return redirect()->route('dashboard');
                }
                if (!$pump) {
                    return redirect()->route('dashboard');
                }


                $device->pump_id = $request->id;
                $device->save();

                return redirect()->route('user.device.config', $id);
            }

            return redirect()->route('logout');
        }

        return redirect()->route('logout');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
