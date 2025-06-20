<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetadataController extends Controller
{
    public function index()
    {
        return view('metadata.index');
    }
}
