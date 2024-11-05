<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<style>
p,b,i {
    style="font-size:8vw;";
}

h1 {
    style="font-size:10vw;";
}
</style>
</head>

<body>
    <div>
        <h1>Davi Rossi Medeiros Lima</h1>
        <p>CPF: 068.626.494-00</p>
        <p>Recibo: {{$code}}</p>
    </div>
    <div>
        <b> Recebi de: </b> <i>{{$nome}}</i>, <b>cpf:</b> <i>{{$cpf}}</i>
    </div>
    
    <div>
        <b> a importancia de: </b> <i>R$</i> <i>{{$vl}}</i>
        <i>, referente ao aluguel de buggy por {{$qtd}} diárias,<br/>com início em {{$dia}}/{{$mes}}/{{$ano}},<br/>pagando de 50% como sinal da reseva.</i>
    </div>
    <br/>
    <br/>
    <div>
        <u><i><b>Fernando de Noronha</b>, </i></u> <u>{{$diah}}</u>/<u>{{$mesh}}</u>/<u>{{$anoh}}</u> <br/> <br/> <br/> <br/> <br/>
    </div>
    <img src="data:image/png;base64,{{$qr}}"/>
    <table>
            <tr>
                <td><img src="/sign.png" style="width: 10%;margin-left: 10%;"/></td>
            </tr>
            <tr>
                <td><b style="margin-left: 10%;">________________________</b></td>
            </tr>
    </table>
    <button onclick="window.print()">Imprimir</button>
</body>
</html>