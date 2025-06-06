<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\Filterable;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
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
    use Filterable;
    public function list(Request $request)
    {
        $query = User::query();

        $filters = [
            'id' => '=',
            'name' => function ($query, $value) {
                $query->where('name', 'like', '%' . $value . '%');
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
        $this->applyFilters($query, $request->session(), 'users', $filters);
        $collection = $query->orderBy('id')->paginate(30);
        return view('admin.users.list', ['collection' => $collection]);
    }

    public function new()
    {
        return view('admin.users.new');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'telephone' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = new User([
                'name' => $request->name,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->save();

            return redirect()->route('admin.users')->with('success', 'Usuário criado com sucesso');
        } catch (ValidationException $e) {
            // Captura erro de validação e retorna os erros com old input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erro ao validar os dados. Verifique os campos informados.');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar este usuário.');
        }
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'telephone' => 'required|string|max:20',
                'email' => 'required|email',
            ]);

            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'telephone' => $request->telephone,
                'email' => $request->email,
            ]);

            return redirect()->route('admin.users')->with('success', 'Usuário atualizado com sucesso');
        } catch (ValidationException $e) {
            // Captura erro de validação e retorna os erros com old input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erro ao validar os dados. Verifique os campos informados.');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar este usuário.');
        }
    }

    public function editPassword($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.password', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);
            $user = User::findOrFail($id);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('admin.users.edit', $id)->with('success', 'Senha atualizada com sucesso');
        } catch (ValidationException $e) {
            // Captura erro de validação e retorna os erros com old input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erro ao validar os dados. Verifique os campos informados.');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar a senha deste usuário');
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = $status;
            $user->save();

            return redirect()->route('admin.users')->with('success', 'Status do usuário atualizado com sucesso');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Erro ao atualizar o status do usuário.');
        }
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users')->with('success', 'Usuário excluído com sucesso');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Erro ao excluir o usuário.');
        }
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
                    "email" => "required|email|max:200"
                ]);

                // Atualizar o usuário com os dados validados
                $user->update([
                    "name" => $request->name,
                    "lastname" => $request->lastname,
                    "telephone" => $request->telephone,
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
}
