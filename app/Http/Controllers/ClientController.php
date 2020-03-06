<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function getClients(Request $request){
        return Client::select('id','email','join_date')->get();
    }
}
