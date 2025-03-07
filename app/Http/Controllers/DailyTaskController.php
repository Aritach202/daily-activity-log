<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyTask;
class DailyTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = DailyTask::latest()->get();
        return view('daily-tasks/create', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $query = DailyTask::query();
        $statusSummary = null;

        if ($request->has('search_date')) {
            $searchDate = $request->search_date;
            $query->whereDate('start_time', $searchDate)
                  ->orWhereDate('end_time', $searchDate);
        }

        if ($request->filled('search_month') && $request->filled('search_year')) {
            $month = $request->search_month;
            $year = $request->search_year;
            
            // Query for tasks in the selected month
            $query->where(function($q) use ($month, $year) {
                $q->whereMonth('start_time', $month)
                  ->whereYear('start_time', $year)
                  ->orWhere(function($q2) use ($month, $year) {
                      $q2->whereMonth('end_time', $month)
                         ->whereYear('end_time', $year);
                  });
            });

            // Calculate status summary for the month
            $statusSummary = [
                'in_progress' => $query->clone()->where('status', 'in_progress')->count(),
                'completed' => $query->clone()->where('status', 'completed')->count(),
                'cancelled' => $query->clone()->where('status', 'cancelled')->count(),
                'total' => $query->clone()->count(),
                'month' => $month,
                'year' => $year
            ];
        }

        $tasks = $query->latest()->get();
        return view('daily-tasks.create', compact('tasks', 'statusSummary'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Development,Test,Document',
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:start_time',
            'status' => 'required|in:in_progress,completed,cancelled',
        ]);

        DailyTask::create($request->all());

        return redirect()->route('daily-tasks.create')
            ->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = DailyTask::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
