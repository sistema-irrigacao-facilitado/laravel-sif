<?php

use Illuminate\Support\Facades\Auth;

function getAuthUser()
{
    if (Auth::guard('admin')->check()) {
        return Auth::guard('admin')->user();
    }
    if (Auth::guard('web')->check()) {
        return Auth::guard('web')->user();
    }
}
function dateFormat($datetime, $noTime = false)
{
    if ($noTime == true) {
        return $datetime->format('d/m/Y');
    }
    return $datetime->format('d/m/Y H:i:s');
}
function periodFormat($period)
{
    $segundos = $period / 1000;

    // Calcula minutos e segundos
    $minutos = floor($segundos / 60);
    $segundos = $segundos % 60;

    // Formata a saída
    return sprintf("%02d:%02d", $minutos, $segundos);
}
function periodUnFormat($tempoString)
{
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

function statusSpan($status)
{
    switch ($status) {
        case 0:
            return "<span class='badge bg-warning me-1'></span> Em Espera"; 
            break;
        case 1:
            return "<span class='badge bg-primary me-1'></span> Disponível"; 
            break;
        case 2:
            return "<span class='badge bg-success me-1'></span> Ativado"; 
            break;
        case 8:
            return "<span class='badge bg-info me-1'></span> Análise";
            break;
        case 9:
            return "<span class='badge bg-danger me-1'></span> Desativado"; 
            break;
        case 10:
            return "<span class='badge bg-dark me-1'></span> Excluído"; 
            break;
        
    }
}
