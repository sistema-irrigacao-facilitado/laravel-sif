<?php

namespace App\Http\Controllers;

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
        $devices = Device::where('user_id', getAuthUser()->id)
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
                if ($device->status != 2) {
                    return redirect()->route('user.device.add');
                }
                $device->user_id = $user->id;
                $device->save();
                return redirect()->route('dashboard');
            }
            return redirect()->route('logout');
        }
        return redirect()->route('logout');
    }

    public function report($id)
    {
        $user = User::find(getAuthUser()->id);
        $device = Device::findOrFail($id);
        $dataDevice = DataDevice::where('device_id', $device->id)->first();
        if ($user) {
            if ($user->status == 2) {
                return view(
                    'user.device.report',
                    [
                        'device' => $device,
                        'dataDevice' => $dataDevice
                    ]
                );
            }
            return redirect()->route('logout');
        }
        return redirect()->route('logout');
    }

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
                if (!$device) {
                    return redirect()->route('dashboard');
                }
                if ($device->status != 2) {
                    return redirect()->route('dashboard');
                }

                $request->validate(
                    ["mode" => "required|int|max:2"],
                    ['time_on' => "nullable|time"]
                );
                $device->mode = $request->mode;
                if ($request->time_on) {
                    if ($request->time_on != $device->time_on && $device->mode == 2) {
                        $device->time_on = $request->time_on;
                    }
                }

                $device->save();

                return redirect()->route('user.device.config', $id);
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
