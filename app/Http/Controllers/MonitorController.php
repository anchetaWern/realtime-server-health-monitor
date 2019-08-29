<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Host;
use Illuminate\Support\Facades\Cache;

class MonitorController extends Controller
{
  public function index()
  {
    $hosts = Host::get();
    return view('monitor', [
      'hosts' => $hosts
    ]);
  }


  public function updatePageVisibility()
  {
    Cache::put('page_visibility', request('state'));
    return 'ok';
  }
}