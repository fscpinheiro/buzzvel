<?php

namespace App\Http\Controllers;

use App\Models\HolidayPlan;
//use Illuminate\Http\Request;
use App\Http\Requests\HolidayPlanRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PDF;

class HolidayPlanController extends Controller
{
    public function index()
    {
        $holidayPlans = HolidayPlan::all();
        return response()->json(['message' => 'Holiday plans retrieved successfully', 'data' => $holidayPlans]);
    }

    public function show($id)
    {
        try {
            $holidayPlan = HolidayPlan::findOrFail($id);
            return response()->json(['message' => 'Holiday plan retrieved successfully', 'data' => $holidayPlan]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }
    }

    public function store(HolidayPlanRequest $request)
    {
        $holidayPlan = HolidayPlan::create($request->validated());
        return response()->json(['message' => 'Holiday plan created successfully', 'data' => $holidayPlan], 201);
    }

    public function update(HolidayPlanRequest $request, $id)
    {
        try {
            $holidayPlan = HolidayPlan::findOrFail($id);
            $holidayPlan->update($request->validated());
            return response()->json(['message' => 'Holiday plan updated successfully', 'data' => $holidayPlan]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $holidayPlan = HolidayPlan::findOrFail($id);
            $holidayPlan->delete();

            return response()->json(['message' => 'Holiday plan deleted successfully'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }
    }

    public function generatePDF($id)
    {
        try {
            $holidayPlan = HolidayPlan::findOrFail($id);
    
            $pdf = PDF::loadView('pdf.holidayplan', ['holidayPlan' => $holidayPlan]);
            return $pdf->download('holidayplan.pdf');
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }
    }
}
