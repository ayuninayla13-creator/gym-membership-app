<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::with('member.user', 'rfidCard')
            ->when($request->date, fn ($q, $date) => $q->whereDate('check_in_at', $date), fn ($q) => $q->whereDate('check_in_at', today()))
            ->latest('check_in_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.attendance.index', compact('attendances'));
    }

    public function storeManual(Request $request)
    {
        $data = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
        ]);

        Attendance::create([
            'member_id' => $data['member_id'],
            'method' => 'manual',
            'check_in_at' => now(),
        ]);

        return back()->with('success', 'Check-in manual berhasil dicatat.');
    }
}
