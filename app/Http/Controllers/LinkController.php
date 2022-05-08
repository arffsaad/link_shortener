<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;

class LinkController extends Controller
{
    public function landing(){
        return view('welcome');
    }

    public function createLink(Request $request){
        $data = $request->all();
        $random = Str::random(8);
        if (substr($data['target'],4) != "http"){
            $data['target'] = "http://" . $data['target'];
        }
        Link::create([
            'target' => $data['target'],
            'identifier' =>  $random
        ]);
        $url = URL::current() . "/red/" . $random;
        return view('welcome', compact('url'));
    }

    public function redirect(){
        $ident = request()->route('ident');
        $redir = Link::where('identifier', $ident)->pluck('target');
        return redirect()->away($redir[0]);
    }
}
