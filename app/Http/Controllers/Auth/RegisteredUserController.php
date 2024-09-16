<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'digits_between:9,15'],  // Le numéro doit avoir entre 9 et 15 chiffres

            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => \Hash::make($request->password),
            'creatd_at'=> now()
        ]);

        // Vérifier si un lien d'affiliation est présent
        if ($request->has('user_id')) {
            $referredBy = User::find($request->get('user_id'));

            if ($referredBy) {
                // Associer le nouvel utilisateur à l'utilisateur qui l'a référé
                $user->referred_by = $referredBy->id;
                $user->save();
            }
        }

        // Génération du lien d'affiliation unique
        $user->generateReferralLink();

        event(new Registered($user));

        Auth::login($user);

        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.users');
        }
        return redirect(route('packs.index', absolute: false));
    }


}
