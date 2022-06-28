<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ReviewModel;
use App\Models\PackageModel;
use App\Models\CountryModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;

use Illuminate\Support\Facades\Validator;

class ApiController extends EmailController
{
    //mz
    public function index()
    {
        $data = PackageModel::with('getImages')->with('getCountry')->orderBy('id', 'desc')->where('status', 0)->take(5)->get();
        if ($data) {
            return response()->json([
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Package not found'
            ], 404);
        }
    }

    public function country()
    {
        $data = CountryModel::all();

        if ($data) {
            return response()->json([
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Country Not Found',
            ], 404);
        }
    }

    public function countryPackages($id)
    {
        if ($id) {
            $data = PackageModel::where('country_id', $id)->with('getImages')->with('getCountry')->where('status', 0)->get();
            if ($data) {
                return response()->json([
                    'data' => $data,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Packages Not Found',
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Please select country',
            ], 404);
        }
    }

    public function search(Request $request, $id)
    {
        if ($id) {
            if ($request->is_price == 1 && $request->start_price !== null && $request->end_price !== null) {
                $data = PackageModel::with('getImages')->with('getCountry')->where('country_id', $id)->where('price', '>=', $request->start_price)->where('price', '<=', $request->end_price)->orderBy('id', 'DESC')->get();
            } elseif ($request->is_price == 0 && $request->is_price !== null) {
                $data = PackageModel::with('getImages')->with('getCountry')->where('country_id', $id)->orderBy('id', 'DESC')->get();
            } else {
                return response()->json([
                    'message' => 'Is Price Empty',
                ], 401);
            }
            if ($data && count($data) > 1) {
                return response()->json([
                    'data' => $data,
                ], 200);
            } elseif (count($data) < 1) {
                return response()->json([
                    'data' => $data,
                ], 404);
            } else {
                return response()->json([
                    'message' => 'Packages Not Found',
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Country Not Found',
            ], 404);
        }
    }

    //Review
    public function reviews()
    {
        $reviews = ReviewModel::where('status', 1)->with('getReviewUser')->get();
        $review_star = ReviewModel::where('status', 1)->pluck('star')->avg();
        $review_avg = number_format((float)$review_star, 1, '.', '');


        if ($reviews && $review_avg) {
            return response()->json([
                'reviews' => $reviews,
                'review_avg' => $review_avg,
            ], 200);
        } else {
            return response()->json([
                'data' => $reviews,
                'message' => 'Review Not Found',
            ], 404);
        }
    }
    //mz

}
