<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MissionRequest;
use App\Models\Client;
use App\Models\Lawyer;
use App\Models\Missions;
use App\Models\SubmitfinishedMission;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    public function create()
    {
        $lawyers = Lawyer::get();
        $clients = Client::get();
        return view('admin.missions.create', compact('lawyers', 'clients'));
    }
    public function store(MissionRequest $request)
    {
        $validated = $request->validated();
        $validated['added_by_id'] = Auth::user()->id;
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('missions', 'public');
        }
        Missions::create($validated);
        return redirect()->route('mission.unfinished')->with('success', 'تم اضافة المهمة بنجاح');
    }

    public function index1()
    {
        $missions = Missions::with('added_by', 'client', 'submitFinishedMissions.firstLawyer', 'submitFinishedMissions.secondLawyer', 'first_lawyer', 'second_lawyer')
            ->where('is_active', 1)
            ->where('is_done', 0)
            ->get();
        return view('admin.missions.index', compact('missions'));
    }

    public function destroy(Missions $mission)
    {
        $mission->update(['is_active' => 0]);
        return redirect()->back()->with('success', 'تم حذف المهمة بنجاح');
    }

    public function finished(Missions $mission)
    {
        $submits = $mission->submitFinishedMissions;

        $hasFirstLawyer = $submits->whereNotNull('first_lawyer_id')->isNotEmpty();

        if (!$hasFirstLawyer) {
            if ($mission->first_lawyer_id == auth()->id() || $mission->second_lawyer_id == auth()->id()) {
                $submits = SubmitfinishedMission::create([
                    'mission_id' => $mission->id,
                    'first_lawyer_id' => auth()->user()->id,
                ]);
                return redirect()->back()->with('success', 'المهمة لم تنته بعد، في انتظار المحامي الثاني.');
            }
        }

        $submit = SubmitfinishedMission::where('mission_id', $mission->id)->first();
        if ($submit && $submit->first_lawyer_id == auth()->id()) {
            return redirect()->back()->with('error', 'لقد قمت بإنهاء المهمة بالفعل، في انتظار المحامي الثاني.');
        }
        if ($hasFirstLawyer && (auth()->user()->id == $mission->second_lawyer_id || auth()->user()->id == $mission->first_lawyer_id)) {
            SubmitfinishedMission::where('mission_id', $mission->id)->update(['second_lawyer_id' => auth()->id()]);
            $mission->update(['is_done' => 1]);
            return redirect()->back()->with('success', 'تم انجاز المهمة بنجاح');
        }

        return redirect()->back()->with('error', 'ليس لديك صلاحيات لهذه المهمه');
    }

    public function unfinished(Missions $mission)
    {
        $mission->update(['is_done' => 0]);
        return redirect()->back()->with('success', 'تم تعديل المهمة بنجاح');
    }

    public function index()
    {
        $missions = Missions::where('is_done', 1)->where('is_active', 1)->get();
        return view('admin.missions.index1', compact('missions'));
    }

    public function restore(Missions $mission)
    {
        $mission->update(['is_active' => 1, 'is_done' => 0]);
        return redirect()->route('mission.indexDelete')->with('success', 'تم تعديل المهمة بنجاح');
    }

    public function deletedMissions()
    {
        $missions = Missions::where('is_active', 0)->get();
        return view('admin.missions.deleted', compact('missions'));
    }

    public function myMissions()
    {
        $lawyerId = Auth::id(); // لو المحامي بيسجل دخول بنفس جدول Lawyer

        $myMissions = Missions::where('is_done', 0)
            ->where(function ($query) use ($lawyerId) {
                $query->where('first_lawyer_id', $lawyerId)
                    ->orWhere('second_lawyer_id', $lawyerId);
            })
            ->get();
        return view('admin.missions.myMissions', compact('myMissions'));
    }
}