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


function gerarqrb64($c)
{
    include(__DIR__.'/../vendor/phpqrcode/qrlib.php');    
    QRcode::png(env("APP_URL") . "/recibo/$c", __DIR__."/../../public_html/qrs/$c.png");    
    $binpng = file_get_contents(__DIR__."/../../public_html/qrs/$c.png");    
    unlink(__DIR__."/../../public_html/qrs/$c.png");    
    $ret = base64_encode($binpng) . "";    
    return $ret;
}

Route::get('/', function () {
    if (App::environment('local')) {
        return view('intro', ["callback_rgs" => "onclick=rgs()"]);
    } else {
        return view('intro', ["callback_rgs" => "class=g-recaptcha data-sitekey=6LdcGdQZAAAAAHhiBdurDCj9OPbHcR7p4Wmj_TaC data-callback=onSubmit data-action=submit"]);
    }
});

Route::get('/TestJSONUpaBE', function () {
    
    $json = [['key' => 0, 'quest' => "Paciente apresenta sangramento?"],
        ['key' => 1, 'quest' => "Paciente sente dores a mais de um dia?"],
        ['key' => 2, 'quest' => "Paciente apresenta lesões ou fraturas?"],
        ['key' => 3, 'quest' => "Paciente apresenta nenhum dos sintomas acima."]];
        
    return response()->json($json);
});

Route::get('/recibo/{c}', function ($c) {
    $r = DB::table('recibos')->where('code', $c)->first();
    
    if (is_null($r))
    {
        return view("rossi");
    }
    
    $rd = $r->created_at;
    
    return view('app', 
                    [
                        "nome" => $r->nome,
                        "cpf" => $r->cpf,
                        "vl" => $r->valor,
                        "qtd" => $r->qtd,
                        "dia" => $r->dia,
                        "mes" => $r->mes,
                        "ano" => $r->ano,
                        "diah" => substr($rd, 8, 2),
                        "mesh" => substr($rd, 5, 2),
                        "anoh" => substr($rd, 0, 4),
                        "code" => $c,
                        "qr" => $r->qr
                    ]
                );
});

Route::post('/approssibknd', function (Request $request) {
    $code = time(); echo "OK1";
    DB::table('recibos')->insert(
        array(
            "nome" => $request->all("nome")["nome"],
            "cpf" => $request->all("cpf")["cpf"],
            "valor" => $request->all("vl")["vl"],
            "qtd" => $request->all("qtd")["qtd"],
            "dia" => $request->all("d")["d"],
            "mes" => $request->all("m")["m"],
            "ano" => $request->all("a")["a"],
            "code" => "$code",
            "qr" => gerarqrb64($code)
        )
    );
    
    if (!App::environment('local'))
    {
        mail ( "douglasjfm@gmail.com, davimedeiros.rossi@hotmail.com" , "Recibo $code gerado" , env("APP_URL", "http://error") . "/recibo/$code");
    }

    return view('app', 
                    [
                        "nome" => $request->all("nome")["nome"],
                        "cpf" => $request->all("cpf")["cpf"],
                        "vl" => $request->all("vl")["vl"],
                        "qtd" => $request->all("qtd")["qtd"],
                        "dia" => $request->all("d")["d"],
                        "mes" => $request->all("m")["m"],
                        "ano" => $request->all("a")["a"],
                        "diah" => date("d"),
                        "mesh" => date("m"),
                        "anoh" => date("Y"),
                        "code" => "********",
                        "qr" => "0000"
                    ]
                );
});

Route::get('/approssi', function () {
    return view('rossi');
});

Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//////////////////////////////LOGICA LINQ.FUN//////////////////////////////////
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
    
    //App\Models\Registro::all();
    
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