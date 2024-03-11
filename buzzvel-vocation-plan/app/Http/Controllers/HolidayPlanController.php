<?php

namespace App\Http\Controllers;

use App\Models\HolidayPlan;
//use Illuminate\Http\Request;
use App\Http\Requests\HolidayPlanRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PDF;
use Illuminate\Support\Facades\Log;


 /**
 * @OA\Schema(
 *     schema="HolidayPlan",
 *     type="object",
 *     @OA\Property(
 *         property="title",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date"
 *     ),
 *     @OA\Property(
 *         property="location",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="participants",
 *         type="string"
 *     )
 * )
 */

class HolidayPlanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/holiday-plans",
     *     summary="Retrieve all holiday plans",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     * )
     */
    public function index()
    {
        $holidayPlans = HolidayPlan::all();
        return response()->json(['message' => 'Holiday plans retrieved successfully', 'data' => $holidayPlans]);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/holiday-plans/{id}",
     *     summary="Retrieve a specific holiday plan by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the holiday plan to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Holiday plan not found",
     *     ),
     * )
     */    
    public function show($id)
    {
        try {
            $holidayPlan = HolidayPlan::findOrFail($id);
            return response()->json(['message' => 'Holiday plan retrieved successfully', 'data' => $holidayPlan]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/v1/holiday-plans",
     *     summary="Create a new holiday plan",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/HolidayPlan")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Holiday plan created successfully",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     ),
     * )
     */
    public function store(HolidayPlanRequest $request)
    {
        Log::info('Store method called', ['request' => $request->all()]);
        $validated = $request->validated();
        $holidayPlan = HolidayPlan::create($validated);
        return response()->json(['message' => 'Holiday plan created successfully', 'data' => $holidayPlan], 201);
    }
    /**
     * @OA\Put(
     *     path="/api/v1/holiday-plans/{id}",
     *     summary="Update an existing holiday plan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the holiday plan to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/HolidayPlan")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Holiday plan updated successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Holiday plan not found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     ),
     * )
     */
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
    /**
     * @OA\Delete(
     *     path="/api/v1/holiday-plans/{id}",
     *     summary="Delete a holiday plan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the holiday plan to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Holiday plan deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Holiday plan not found",
     *     ),
     * )
     */
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
    /**
     * @OA\Post(
     *     path="/api/v1/holiday-plans/{id}/pdf",
     *     summary="Generate PDF for a specific holiday plan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the holiday plan to generate PDF",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF generated successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Holiday plan not found",
     *     ),
     * )
     */
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
