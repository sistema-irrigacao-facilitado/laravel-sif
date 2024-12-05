<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\Filterable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(){
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
            'cpf' => function ($query, $value) {
                $query->where('cpf', 'like', '%' . $value . '%');
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
        return view('admin.user.list', ['collection' => $collection]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
}
