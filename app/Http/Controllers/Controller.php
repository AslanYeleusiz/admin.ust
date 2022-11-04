<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResponse($data, $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $data], $status);
    }

    /**
     * @param $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendError($data, $status = 422): \Illuminate\Http\JsonResponse
    {
        return response()->json(['errors' => $data], $status);
    }

    /**
     * @param string $permission
     * @return bool
     */
    protected function checkPermission($permission = ''): bool
    {

        if (! auth()->user()->can($permission)) {
            return false;
        }

        return true;
    }
}
