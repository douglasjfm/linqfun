<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (App::environment('local')) {
        return view('intro', ["callback_rgs" => "onclick=rgs()"]);
    } else {
        return view('intro', ["callback_rgs" => "class=g-recaptcha data-sitekey=6LdcGdQZAAAAAHhiBdurDCj9OPbHcR7p4Wmj_TaC data-callback=onSubmit data-action=submit"]);
    }
});

Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('/_hash', function (Request $request) {
    $link = $request->all("l");
    $aut = $request->all("aut");
    $hash = "";
    $hash_tam = 3;

    if ($aut["aut"] == "t") {
        $test = ".";
        $hash0 = hash("sha256", $link["l"], false);
        do
        {
            $i = 0;
            $lim = strlen($hash0) - $hash_tam;

            while (!is_null($test) && $i < $lim)
            {
                $hash = substr($hash0, $i, $hash_tam);
                $test = App\Models\Registro::where("linq", $hash)->first();
                $i = $i + 1;
            }

            if(is_null($test)) break;
            else $hash_tam = $hash_tam + 1;

        }while ($hash_tam < 15);
    }
    else
    {
        $hash = substr($request->all("frase")["frase"], 0, 25);
        if (strlen($hash) > 12) return '{"r":1, "m": "invalid phrase"}';
        if (!ctype_alnum($hash)) return '{"r":1, "m": "invalid phrase"}';
        $test = App\Models\Registro::where("linq", $hash)->first();
        if (!is_null($test)) return '{"r":2, "m": "phrase already in use"}';
    }
    $ret_linq = env("APP_URL", "https://linq.fun") . "/" . $hash;
    return '{"r":0, "m": "'.$ret_linq.'"}';
});

Route::post('/_regis', function (Request $request) {
        
    $q = substr($request->all("h")["h"], 0, 25);
    $l = substr($request->all("l")["l"], 0, 1024);
    
    if (filter_var($l, FILTER_VALIDATE_URL, ["options" => ["max_range" => 1024]]) == false) {
        return "-1|invalid input";
    }
    
    if (!ctype_alnum($q)) {
        return "-2|invalid input";
    }
    
    $rg = new App\Models\Registro;
    $rg->link = $l;
    $rg->linq = $q;
    $rg->ativo = true;

    $test = App\Models\Registro::where("linq", $q)->first();

    if (is_null($test))
    {
        $lid = $rg->save();
        return "$lid|$q";
    }
    else return "0|phrase already in use";
});

Route::get('/{q}', function ($q) {

    $r = App\Models\Registro::where("linq", $q)->first();

    if (is_null($r))
    {
        return redirect('/');
    }
    
    $r->contador = $r->contador + 1;
    $r->save();

    return view("redir", ["link" => $r->link]);
});