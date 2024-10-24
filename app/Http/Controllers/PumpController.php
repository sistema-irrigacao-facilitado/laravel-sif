<?php

namespace App\Http\Controllers;

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
