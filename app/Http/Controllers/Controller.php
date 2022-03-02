<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     /**
     * Get input request service
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $key
     * @param $default
     * @return mixed
     */
    protected function getInput(Request $request, string $key, $default = null)
    {
        $data = $request->input($key, $default);
        return $data == null ? $default : $data;
    }
}
