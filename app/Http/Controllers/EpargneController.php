<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Epargne;
use Illuminate\Http\Request;

class EpargneController extends Controller
{
    public function index()
    {
        $epargnes = Epargne::get();
        // die;
        return view('epargne.index', compact('epargnes'));

    }

    //
}