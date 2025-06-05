<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Http\Traits\Filterable;
use App\Models\AverageData;
use App\Models\Collaborator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CollaboratorController extends Controller
{


    public function index()
    {
        return view('admin.dashboard');
    }

    use Filterable;
    public function list(Request $request)
    {
        $query = Collaborator::query();
        $filters = [
            'id' => '=',
            'name' => function ($query, $value) {
                $query->where('name', 'like', '%' . $value . '%');
            },
            'lastname' => function ($query, $value) {
                $query->where('lastname', 'like', '%' . $value . '%');
            },
            'telephone' => function ($query, $value) {
                $query->where('telephone', 'like', '%' . $value . '%');
            },
            'email' => function ($query, $value) {
                $query->where('email', 'like', '%' . $value . '%');
            },

            'created_at_from' => function ($query, $value) {
                $query->whereDate('created_at', '>=', $value);
            },
            'created_at_to' => function ($query, $value) {
                $query->whereDate('created_at', '<=', $value);
            },
            'status' => '=',
        ];
        $this->applyFilters($query, $request->session(), 'admins', $filters);
        $collection = $query->orderBy('id')->paginate(30);
        return view('admin.list', ['collection' => $collection]);
    }

    public function new()
    {
        return view('admin.new');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:collaborators,email',
                'password' => 'required|string|min:6|confirmed',
                'telephone' => 'nullable|string|max:20',
            ]);

            $collaborator = new Collaborator([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'telephone' => $request->telephone,
            ]);

            $collaborator->save();

            return redirect()->route('admin.list')->with('success', 'Colaborador criado com sucesso');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar este colaborador.');
        }
    }


    public function edit($id)
    {
        $collaborator = Collaborator::findOrFail($id);
        return view('admin.edit', compact('collaborator'));
    }

     public function editPassword($id)
    {
        $collaborator = Collaborator::findOrFail($id);
        return view('admin.editPassword', compact('collaborator'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:collaborators,email,' . $id,
                'telephone' => 'nullable|string|max:20',
            ]);

            $collaborator = Collaborator::findOrFail($id);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'telephone' => $request->telephone,
            ];

            $collaborator->update($data);

            return redirect()->route('admin.list')->with('success', 'Colaborador atualizado com sucesso');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar este colaborador.');
        }
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            $request->validate([
                'password' => 'nullable|string|min:6|confirmed',
            ]);

            $collaborator = Collaborator::findOrFail($id);

            $data = [];
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $collaborator->update($data);

            return redirect()->route('admin.list')->with('success', 'Colaborador atualizado com sucesso');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar este colaborador.');
        }
    }


    public function updateStatus($id, $status)
    {
        try {
            $collaborator = Collaborator::findOrFail($id);
            $collaborator->status = $status;
            $collaborator->save();

            return redirect()->route('admin.list')->with('success', 'Status do colaborador atualizado com sucesso');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao atualizar o status do colaborador.');
        }
    }

    public function delete($id)
    {
        try {
            $collaborator = Collaborator::findOrFail($id);
            $collaborator->delete();

            return redirect()->route('admin.list')->with('success', 'Colaborador excluído com sucesso');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao excluir o colaborador.');
        }
    }
}
