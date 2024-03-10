<?php

namespace App\Http\Controllers;

use App\Models\HolidayPlan;
use Illuminate\Http\Request;

class HolidayPlanController extends Controller
{
    public function index()
    {
        $holidayPlans = HolidayPlan::all();
        return response()->json($holidayPlans);
    }

    public function show($id)
    {
        $holidayPlan = HolidayPlan::find($id);
        return response()->json($holidayPlan);
    }

    public function store(Request $request)
    {
        $holidayPlan = new HolidayPlan;
        $holidayPlan->title = $request->title;
        $holidayPlan->description = $request->description;
        $holidayPlan->date = $request->date;
        $holidayPlan->location = $request->location;
        $holidayPlan->participants = $request->participants;
        $holidayPlan->save();

        return response()->json($holidayPlan, 201);
    }

    public function update(Request $request, $id)
    {
        $holidayPlan = HolidayPlan::find($id);
        $holidayPlan->title = $request->title;
        $holidayPlan->description = $request->description;
        $holidayPlan->date = $request->date;
        $holidayPlan->location = $request->location;
        $holidayPlan->participants = $request->participants;
        $holidayPlan->save();

        return response()->json($holidayPlan);
    }

    public function destroy($id)
    {
        $holidayPlan = HolidayPlan::find($id);
        $holidayPlan->delete();

        return response()->json(null, 204);
    }

    public function generatePDF($id)
    {
        return response()->json(null, 200);
    }
}
