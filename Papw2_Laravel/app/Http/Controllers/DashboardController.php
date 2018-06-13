<?php

namespace App\Http\Controllers;

use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DashboardController extends Controller
{
    //
    public function verDashboad(){
    	if(Auth::check()){
    		if(Auth::user()->esVendedor()){
    			return view('dashboard_vendedor');
    		}else if (Auth::user()->esAdmin()){
    			return view('dashboard_admin');
    		}
    	}

		return redirect(route('landing'));
    }

    public function verLanding(){

        if(Auth::check()){
        	/*  
          	if(Auth::user()->esAdmin() || Auth::user()->esVendedor())
                return redirect('dashboard');
            */
            return redirect('busqueda');
        }

        return view('landing');
    }
}
