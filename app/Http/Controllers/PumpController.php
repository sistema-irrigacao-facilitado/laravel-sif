<?php

namespace App\Http\Controllers;

use App\Http\Traits\Filterable;
use App\Models\Device;
use App\Models\Pump;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PumpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    use Filterable;
    public function list(Request $request)
    {
        $query = Pump::query();
        $filters = [
            'id' => '=',
            'model' => function ($query, $value) {
                $query->where('model', 'like', '%' . $value . '%');
            },
            'flow' => function ($query, $value) {
                $query->where('flow', 'like', '%' . $value . '%');
            },
            'created_at_from' => function ($query, $value) {
                $query->whereDate('created_at', '>=', $value);
            },
            'created_at_to' => function ($query, $value) {
                $query->whereDate('created_at', '<=', $value);
            },
            'status' => '=',
        ];
        $this->applyFilters($query, $request->session(), 'pumps', $filters);
        $collection = $query->orderBy('id')->paginate(30);
        return view('admin.pump.list', ['collection' => $collection]);
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

    public function select($id){
        $user = User::find(getAuthUser()->id);
        $device = Device::findOrFail($id)->first();
        $pumps = Pump::paginate();
        foreach ($pumps as $pump) {
            // Decodificando a imagem
            $decodedImage = base64_decode($pump->image);
    
            // Criando um data URI (recomendado para evitar criar arquivos temporários)
            $imageDataUri = 'data:image/jpeg;base64,' . base64_encode($decodedImage);
    
            // Passando os dados para a view
            $pump->image_url = $imageDataUri;
        }

        if ($user) {
            if ($user->status == 2) {
                if (!$device) {
                    return redirect()->route('dashboard');
                }
                
                if ($device->status != 2) {
                    return redirect()->route('dashboard');
                }
                if(!$pumps){
                    return redirect()->route('dashboard');
                }
                return view('user.device.select.pump', [
                    'device' => $device,
                    'pumps' => $pumps,
                ]);
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

   
}
