<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $apiToken = $request->attributes->get('api_token');

        return response()->json([
            'name' => $apiToken->name,
            'abilities' => $apiToken->abilities ?? [],
            'last_used_at' => $apiToken->last_used_at?->toDateTimeString(),
        ]);
    }
}
