<?php

namespace App\Http\Controllers;

use App\Http\Traits\Filterable;
use App\Models\Device;
use App\Models\Plant;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PlantController extends Controller
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
        $query = Plant::query();
        $filters = [
            'id' => '=',
            'common_name' => function ($query, $value) {
                $query->where('common_name', 'like', '%' . $value . '%');
            },
            'scientific_name' => function ($query, $value) {
                $query->where('scientific_name', 'like', '%' . $value . '%');
            },
            'created_at_from' => function ($query, $value) {
                $query->whereDate('created_at', '>=', $value);
            },
            'created_at_to' => function ($query, $value) {
                $query->whereDate('created_at', '<=', $value);
            },
            'status' => '=',
        ];
        $this->applyFilters($query, $request->session(), 'plants', $filters);
        $collection = $query->orderBy('id')->paginate(30);
        return view('admin.plants.list', ['collection' => $collection]);
    }

    public function new()
    {
        return view('admin.plants.new');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'common_name' => 'required|string|max:255',
                'scientific_name' => 'required|string|max:255',
                'water_need' => 'required|string|max:255',
                'soil_type' => 'required|string|max:255',
                'humidity_tolerance' => 'required|string|max:255',
                'temperature_tolerance' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'obs' => 'nullable|string',
            ]);

            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('plants', 'public');
            }

            $plant = new Plant([
                'common_name' => $request->common_name,
                'scientific_name' => $request->scientific_name,
                'water_need' => $request->water_need,
                'soil_type' => $request->soil_type,
                'humidity_tolerance' => $request->humidity_tolerance,
                'temperature_tolerance' => $request->temperature_tolerance,
                'image' => $imagePath,
                'obs' => $request->obs,
            ]);

            $plant->save();

            return redirect()->route('admin.plants')->with('success', 'Planta criada com sucesso');
        } catch (ValidationException $e) {
            // Captura erro de validação e retorna os erros com old input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erro ao validar os dados. Verifique os campos informados.');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar esta planta.');
        }
    }


    public function edit($id)
    {
        $plant = Plant::findOrFail($id);
        return view('admin.plants.edit', compact('plant'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'common_name' => 'required|string|max:255',
                'scientific_name' => 'required|string|max:255',
                'water_need' => 'required|string|max:255',
                'soil_type' => 'required|string|max:255',
                'humidity_tolerance' => 'required|string|max:255',
                'temperature_tolerance' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'obs' => 'nullable|string',
            ]);

            $plant = Plant::findOrFail($id);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('plants', 'public');
                $plant->image = $imagePath;
            }

            $plant->update([
                'common_name' => $request->common_name,
                'scientific_name' => $request->scientific_name,
                'water_need' => $request->water_need,
                'soil_type' => $request->soil_type,
                'humidity_tolerance' => $request->humidity_tolerance,
                'temperature_tolerance' => $request->temperature_tolerance,
                'obs' => $request->obs,
            ]);

            return redirect()->route('admin.plants')->with('success', 'Planta atualizada com sucesso');
        } catch (ValidationException $e) {
            // Captura erro de validação e retorna os erros com old input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erro ao validar os dados. Verifique os campos informados.');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar esta planta.');
        }
    }


    public function updateStatus($id, $status)
    {
        try {
            $plant = Plant::findOrFail($id);
            $plant->status = $status;
            $plant->save();

            return redirect()->route('admin.plants')->with('success', 'Status da planta atualizado com sucesso');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao atualizar o status do planta.');
        }
    }

    public function delete($id)
    {
        try {
            $plant = Plant::findOrFail($id);
            $plant->delete();

            return redirect()->route('admin.plants')->with('success', 'Dispositivo excluído com sucesso');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao excluir o dispositivo.');
        }
    }

    public function select($id)
    {
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
                if (!$plants) {
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
