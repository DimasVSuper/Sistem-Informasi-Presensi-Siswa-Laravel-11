<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PresensiRequest;
use App\Services\PresensiService;

class PresensiController extends Controller
{
    public function __construct(protected PresensiService $presensiService) {}

    /**
     * Proses scan QR Code dan simpan presensi.
     * POST /api/presensi
     */
    public function store(PresensiRequest $request)
    {
        $result = $this->presensiService->processScan($request->qr_code);

        $status = $result['status'];
        unset($result['status']); // Jangan kembalikan HTTP Code di dalam payload body

        return response()->json($result, $status);
    }
}
