<?php

namespace App\Http\Controllers;

use App\Http\Traits\Filterable;
use App\Models\Device;
use App\Models\Pump;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
        return view('admin.pumps.list', ['collection' => $collection]);
    }

    public function new()
    {
        return view('admin.pumps.new');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'model' => 'required|string|max:255',
                'flow' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'obs' => 'nullable|string',
            ]);

            $pump = new Pump([
                'model' => $request->model,
                'flow' => $request->flow,
                'image' => $request->image ? $request->image->store('pumps', 'public') : null,
                'obs' => $request->obs,
            ]);

            $pump->save();

            return redirect()->route('admin.pumps')->with('success', "Bomba d'água criada com sucesso");
        } catch (ValidationException $e) {
            // Captura erro de validação e retorna os erros com old input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erro ao validar os dados. Verifique os campos informados.');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', "Ocorreu um erro ao salvar esta bomba d'água.");
        }
    }

    public function edit($id)
    {
        $pump = Pump::findOrFail($id);
        return view('admin.pumps.edit', compact('pump'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'model' => 'required|string|max:255',
                'flow' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'obs' => 'nullable|string',
            ]);

            $pump = Pump::findOrFail($id);
            $pump->model = $request->model;
            $pump->flow = $request->flow;
            $pump->obs = $request->obs;

            if ($request->hasFile('image')) {
                $pump->image = $request->image->store('pumps', 'public');
            }

            $pump->save();

            return redirect()->route('admin.pumps')->with('success', "Bomba atualizada com sucesso");
        } catch (ValidationException $e) {
            // Captura erro de validação e retorna os erros com old input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erro ao validar os dados. Verifique os campos informados.');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', "Ocorreu um erro ao atualizar esta bomba.");
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $pump = Pump::findOrFail($id);
            $pump->status = $status;
            $pump->save();

            return redirect()->route('admin.pumps')->with('success', "Status da bomba atualizado com sucesso");
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', "Erro ao atualizar o status da bomba.");
        }
    }

    public function delete($id)
    {
        try {
            $pump = Pump::findOrFail($id);
            $pump->delete();

            return redirect()->route('admin.pumps')->with('success', "Bomba excluída com sucesso");
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', "Erro ao excluir a bomba.");
        }
    }

    public function select($id)
    {
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
                if (!$pumps) {
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
