<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.user.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
           $request->validate([
                'name' => 'required|string|max:255',
                'telephone' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);
            $user = new User();


            $user->name = $request->name;
            $user->telephone = $request->telephone;
            $user->status = 2;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();
            if ($user) {
                event(new Registered($user));

                Auth::login($user);

                return redirect(route('dashboard', absolute: false));
            }
            return redirect()->back()->with('error', 'Não foi possivel fazer o cadastro');
        } catch (ValidationException $e) {
            // Captura erro de validação e retorna os erros com old input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erro ao validar os dados. Verifique os campos informados.');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Ocorreu um erro ao tentar fazer o cadastro');
        }
    }
}
