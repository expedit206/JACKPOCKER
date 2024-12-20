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
    public function create(Request $request): View
    {
        $referredBy = null;

        // Vérifier si un user_id est passé dans l'URL
        if (request('code')) {
            $referredBy = User::find(request('code'));
                        
        }
        return view('auth.register',compact('referredBy'));
    }
    
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request);
        // die;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'telephone' => [
            'required',
            'digits_between:9,15',
            'unique:users,telephone' // Doit être unique dans la table des utilisateurs

        ],  // Le numéro doit avoir entre 9 et 15 chiffres
            'password' => ['required', 'confirmed'],
    ], [
        'name.required' => 'Le champ nom est obligatoire.',
        'name.string' => 'Le champ nom doit être une chaîne de caractères.',
        'name.max' => 'Le champ nom ne peut pas dépasser 255 caractères.',
        
        'telephone.required' => 'Le champ téléphone est obligatoire.',
        'telephone.digits_between' => 'Le numéro de téléphone doit avoir entre 9 et 15 chiffres.',
        'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
    
        'password.required' => 'Le champ mot de passe est obligatoire.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ]
    );
        
        $user = User::create([
            'name' => $request->name,
            'telephone' => $request->telephone,
            'password' => \Hash::make($request->password),
            'created_at'=> now()
        ]);
        $user->password_transaction =\Hash::make('0000');
        $user->save();
        // dd($request);
        
        // Vérifier si un lien d'affiliation est présent
        if ($request['code']) {
            $parrain = User::find($request['code']);
// die;
            if ($parrain) {
                // Associer le nouvel utilisateur à l'utilisateur qui l'a référé
                $user->parrain_id = $parrain->id;
                $user->save();
            }
        }

        // Génération du lien d'affiliation unique
       
        
        event(new Registered($user));

        Auth::login($user);

        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.users');
        }
        return redirect(route('produits.index', absolute: false));
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès.');
    }


}
