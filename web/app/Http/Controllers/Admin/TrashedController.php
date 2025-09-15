<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cases;
use Illuminate\Http\Request;

class TrashedController extends Controller
{
    public function trashedCases($caseTypeId)
    {
        $cases = cases::where('suggested_case_id', $caseTypeId)
            ->whereHas('trahsedDays', function ($query) {
                $query->where('is_seen', 1);
            })
            ->with([
                'trahsedDays' => function ($query) {
                    $query->where('is_seen', 1);
                }
            ])
            ->get();

        return view('admin.cases.trashed', compact('cases'));
    }
}
