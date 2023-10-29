<?php

namespace App\Http\Controllers;

use App\Models\transaccionesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ganancias extends Controller
{
    //
    public function Ganancias(){
        return view('home.ganancias.ganancias');
    }

}
