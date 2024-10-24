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