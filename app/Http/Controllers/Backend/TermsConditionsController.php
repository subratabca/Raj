<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; 
use Exception;
use App\Models\TermCondition;

class TermsConditionsController extends Controller
{
    function TermsConditionsPage(){
        return view('backend.pages.dashboard.terms-conditions-page');
    }


    public function TermsConditionsList(Request $request)
    {
        try {
            $termsConditions = TermCondition::latest()->get();

            if ($termsConditions->isEmpty()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Information not found',
                ], 404); 
            }

            return response()->json([
                'status' => 'success',
                'data' => $termsConditions
            ], 200); 

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred while retrieving foods',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function TermsConditionsCreate(Request $request)
    {
        try {
            $request->validate([
                'food_upload' => 'required|string',
                'request_approve' => 'required|string',
                'food_deliver' => 'required|string',
            ]);

            $termsConditions = TermCondition::create([
                'food_upload'=>$request->input('food_upload'),
                'request_approve'=>$request->input('request_approve'),
                'food_deliver'=>$request->input('food_deliver')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Terms $ Conditions created successfully.',
                'data' => $termsConditions,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Terms $ Conditions creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function TermsConditionsByID(Request $request)
    {
        $id = $request->input('id');

        try {
            $termsCondition = TermCondition::where('id', $id)->first();

            if ($termsCondition) {
                return response()->json([
                    'status' => 'success',
                    'data' => $termsCondition
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Terms & Conditions not found.'
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to retrieve Terms & Conditions.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function UpdateTermsConditions(Request $request)
    {
        try {
            $request->validate([
                'food_upload' => 'required|string',
                'request_approve' => 'required|string',
                'food_deliver' => 'required|string',
            ]);

            $id = $request->input('id');
            $termsCondition = TermCondition::where('id',$id)->first();

            $termsCondition->update([
                'food_upload' => $request->input('food_upload'),
                'request_approve' => $request->input('request_approve'),
                'food_deliver' => $request->input('food_deliver')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Terms $ Conditions updated successfully.',
                'data' => $termsCondition
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Terms $ Conditions update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function DeleteTermsConditions(Request $request)
    {
        $id = $request->input('id');

        try {
            $deleted = TermCondition::where('id', $id)->delete();

            if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Terms & Conditions deleted successfully.'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Terms & Conditions not found.'
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to delete Terms & Conditions.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function TermsConditionsDetailsPage(Request $request)
    {
        $type = basename($request->path());
        return view('backend.pages.dashboard.terms-conditions-details-page', compact('type'));
    }


    public function TermsConditionsByType(Request $request)
    {
        try {
            $column = $request->type;

            if (!in_array($column, (new TermCondition)->getFillable())) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid column name.',
                ], 400);
            }

            $data = TermCondition::pluck($column)->first();

            if (!$data) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No data found.',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'column' => $column,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred while retrieving terms and conditions.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    
}