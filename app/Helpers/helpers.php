<?php
use Illuminate\Support\Facades\Auth;
function getAuthUser(){
    if(Auth::guard('admin')->check()){
        return Auth::guard('admin')->user();
    }
    if(Auth::guard('web')->check()){
        return Auth::guard('web')->user();
    }
}

function periodFormat($period){
    $segundos = $period / 1000;

        // Calcula minutos e segundos
        $minutos = floor($segundos / 60);
        $segundos = $segundos % 60;

        // Formata a saída
        return sprintf("%02d:%02d", $minutos, $segundos);
}
function periodUnFormat($tempoString){
    // Separa minutos e segundos
    list($minutos, $segundos) = explode(':', $tempoString);

    // Converte tudo para segundos
    $segundosTotal = ($minutos * 60) + $segundos;

    // Converte para milissegundos
    $milissegundos = $segundosTotal * 1000;

    return $milissegundos;
}

function extractValuesFromCollection($collection, $fields)
    {
        $result = [];

        foreach ($fields as $field) {
            $result[$field] = $collection->pluck($field)->toArray();
        }

        return $result;
    }