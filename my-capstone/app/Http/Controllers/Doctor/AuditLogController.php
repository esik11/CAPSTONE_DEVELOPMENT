<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    /**
     * Display audit logs (simplified for capstone).
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user')
            ->where('user_id', Auth::id()) // Doctors see only their own logs
            ->orderBy('created_at', 'desc');
        
        // Simple filters
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        if ($request->filled('involves_phi')) {
            $query->where('involves_phi', $request->involves_phi === 'yes');
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $logs = $query->paginate(20);
        
        // Simple statistics
        $stats = [
            'total_count' => AuditLog::where('user_id', Auth::id())->count(),
            'phi_count' => AuditLog::where('user_id', Auth::id())->where('involves_phi', true)->count(),
        ];
        
        return view('doctor.audit-logs.index', compact('logs', 'stats'));
    }
    
    /**
     * Show detailed audit log.
     */
    public function show(AuditLog $auditLog)
    {
        // Ensure user can only view their own logs
        if ($auditLog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to audit log.');
        }
        
        return view('doctor.audit-logs.show', compact('auditLog'));
    }
}
