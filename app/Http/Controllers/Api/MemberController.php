<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScanUid;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function store(Request $request)
    {
        $checkUid = ScanUid::find(1);

        if (!$checkUid) {
            $data = $request->validate([
                'uid'  => 'required|string|max:255',
            ]);
            ScanUid::create($data);
            return response()->json([
                'success'   => true,
                'message' => 'UID berhasil ditambahkan!',
                'uid' => $request->uid,
            ], 200);
        } else {
            $checkUid->update([
                'uid' => $request->uid
            ]);

            return response()->json([
                'success'   => true,
                'message' => 'UID berhasil diperbarui!',
                'uid' => $checkUid->uid,
            ], 200);
        }
    }
}
