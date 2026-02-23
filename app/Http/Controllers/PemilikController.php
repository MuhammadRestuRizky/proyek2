<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemilikController extends Controller
{
    public function dashboard()
    {
        return view('pemilik.dashboard');
    }

    public function create()
    {
        return view('pemilik.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function updateStatus($id)
    {
        //
    }
}
