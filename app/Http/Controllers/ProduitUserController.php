<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\ProduitUser;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProduitUserController extends Controller
{
    public function index()
    {
        // die;
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        $produitUsers = ProduitUser::where('user_id',$user->id )->get();
        // dd($produitUsers);

        foreach ($produitUsers as $produitUser) {
        // die;

        
        if ($produitUser) {
        // die;
            // $revenue = $produitUser->calculateDailyRevenue();

                // Ajouter les revenus au solde de l'utilisateur
                // $user->solde_total += $revenue;
                // die;
                // Mettre à jour le produit utilisateur pour éviter de recalculer
                // $produitUser->last_checked = now(); // Stocker la dernière vérification
                // dd($produitUser->last_checked);
                $produit = Produit::find($produitUser->produit_id) ;
                // dd($produitUser);    
                // Passer la date au JavaScript
            $lastIncrementedAt = new DateTime($produitUser->last_incremented_at); // Exemple : remplacez par votre valeur
            $now = new DateTime('now'); // Date actuelle
            // Convertir les dates en timestamp
            $lastIncrementedAtTimestamp = $lastIncrementedAt->getTimestamp();
            $nowTimestamp = $now->getTimestamp();
            
            // Calculer la différence en jours
            $secondsPerDay = 60*60*24 ; // Nombre de secondes dans un jour
            $daysElapsed = ($nowTimestamp - $lastIncrementedAtTimestamp) / $secondsPerDay;
            
        
        // Vérifiez si le nombre de jours est supérieur ou égal à 1
        // echo "La différence en jours est : " . $daysElapsed . "<br>";
        dd($daysElapsed);
        if ($daysElapsed >= 1) {
            // if ($daysElapsed >= 2) {
                $produitUser->gagner += $produit->gainJ * $daysElapsed;
                $user->solde_total += $produit->gainJ * $daysElapsed;
                $produitUser->last_incremented_at = new DateTime($produitUser->last_incremented_at);
                // Ajouter un jour  
                $produitUser->last_incremented_at->modify("+".$daysElapsed." day" );
            // }
        } 
        $produitUser->save();
        $user->save();
     }
   

    }
        // Récupérer les produits de l'utilisateur avec les données de la table pivot
        $produits = $user->produits()
        ->withPivot(['gagner', 'duration', 'count', 'last_incremented_at', 'created_at'])
        ->orderBy('produit_user.created_at', 'asc') // Utilisation du nom de la table pivot

        ->get();
        // dd(value)
        // dump($produits);
        // Calculer le revenu accumulé et le revenu d'aujourd'hui
        $totalRevenu = $produits->sum('pivot.gagner'); // Utiliser 'pivot' pour accéder aux colonnes de la table pivot
        $revenueToday = $produits->sum(function ($produit) {
            return $produit->gainJ; // Revenu quotidien du produit
        });

        // Calculer la durée restante pour chaque produit
        $soldeTotal = $user->solde_total;

        return view('produit_user.index', compact('produits', 'totalRevenu', 'revenueToday', 'soldeTotal'));
    }

    /**
     * Calculer la durée restante en heures.
     */
    private function calculateRemainingDuration($produitUser)
{
    // Durée initiale en jours
    $initialDurationInDays = $produitUser->nbjour;

    // Convertir la durée initiale en heures
    $initialDurationInHours = $initialDurationInDays * 24;

    // Temps écoulé depuis la création
    $createdAt = Carbon::parse($produitUser->created_at);
    $now = Carbon::now();
// dump($produitUser->created_at);
    // Calculer la différence en heures et en jours
    $diffHours = $now->diffInHours($createdAt);
    $diffDays = $now->diffInDays($createdAt);

    // Total des heures écoulées
    $totalElapsedHours = ($diffDays * 24) + $diffHours;
// dd($diffHours);
    // Calculer la durée restante
    $remainingTimeInHours = $initialDurationInHours - $totalElapsedHours;

    // S'assurer que la durée restante ne soit pas négative
    return max(0, $remainingTimeInHours);
}


public function store(Request $request)
{
    // Validation des données
    $request->validate([
        'produit_id' => 'required|exists:produits,id',
    ]);

    // Récupération de l'utilisateur authentifié
    $user = Auth::user();

    // Récupérer le produit
    $produit = Produit::find($request->produit_id);


    if ($produit->stock == 0) {
        return redirect()->route('produits.index')->with('error', 'Produit non disponible en stock.');
    }
// dd($user->solde_total);
    // Vérifier si l'utilisateur a suffisamment de fonds
    if ($user->solde_total < $produit->montant) {
        return redirect()->route('produits.index')->with('error', 'Fonds insuffisants pour acheter ce produit.');
    }else{
        $user->solde_total -= $produit->montant;
        $user->save();

    }
    // Vérifier la disponibilité du stock
    
    // Vérification si l'utilisateur a déjà acheté ce produit
    $produitUserExist = ProduitUser::where('user_id', $user->id)
    ->where('produit_id', $produit->id)
    ->latest('created_at') // Récupérer la dernière occurrence
    ->first();
    
    if ($produitUserExist && $produit->stock <= $produitUserExist->count) {
        return redirect()->route('produits.index')->with('error', 'Vous avez épuisé votre stock.');
    }

    $produitUser = new ProduitUser();
        if ($produitUserExist) {
            // L'utilisateur a déjà acheté ce produit, on incrémente le compteur
            $produitUser->count =$produitUserExist->count +  1;
        } else {
        // L'utilisateur n'a pas encore acheté ce produit, on crée un nouvel enregistrement
        $produitUser->count = 1; // Initialiser à 1
    }
    $produitUser->user_id = $user->id;
    $produitUser->produit_id = $produit->id;
    $produitUser->gagner = 0; // Initialiser à zéro
    $produitUser->created_at = now(); // Date actuelle
    $produitUser->save(); // Enregistrement dans la base de données

    $produitUserCount= ProduitUser::where('user_id', $user->id)
    ->count();
    if($produitUserCount == 1){//si c'est sa premiere fois d'incestir on calcule  le bonus de ses parrains
        // dd($produitUserCount);

        $this->incrementReferralBonuses($user);
    }

    // Décrémenter le stock du produit
    // $produit->save(); // Enregistrer la mise à jour du stock

    // Redirection avec un message de succès
    return redirect()->route('produit.user.index')->with('success', 'Produit acheté avec succès!');
}

private function incrementReferralBonuses(User $user)
{
    // Récupérer les taux d'intérêt de la configuration
    $tauxInteret = config('parrainage.taux_interet');
    
    // Récupérer le premier parrain du user
    $parrain1 = $user->parrain; // Supposons que tu as une relation définie pour récupérer le parrain

    // Niveau 1
    if ($parrain1) {
        $parrain1->solde_total += $tauxInteret['vip1'];
        $parrain1->save();

        // Niveau 2
        if ($parrain1->parrain) {
            $parrain2 = $parrain1->parrain;
            $parrain2->solde_total += $tauxInteret['vip2'];
            $parrain2->save();

            // Niveau 3
            if ($parrain2->parrain) {
                $parrain3 = $parrain2->parrain;
                $parrain3->solde_total += $tauxInteret['vip3'];
                $parrain3->save();
            }
        }
    }
}
}