<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Plant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function list()
    {
        return view('admin.plant.list');
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
        $plants = Plant::paginate();
        foreach ($plants as $plant) {
            // Decodificando a imagem
            $decodedImage = base64_decode($plant->image);
    
            // Criando um data URI (recomendado para evitar criar arquivos temporários)
            $imageDataUri = 'data:image/jpeg;base64,' . base64_encode($decodedImage);
    
            // Passando os dados para a view
            $plant->image_url = $imageDataUri;
        }

        if ($user) {
            if ($user->status == 2) {
                if (!$device) {
                    return redirect()->route('dashboard');
                }
                
                if ($device->status != 2) {
                    return redirect()->route('dashboard');
                }
                if(!$plants){
                    return redirect()->route('dashboard');
                }
                return view('user.device.select.plant', [
                    'device' => $device,
                    'plants' => $plants,
                ]);
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

    
}
