<?php

namespace App\Http\Controllers\API;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ProductController extends Controller
{
    public function index() //// list products
    {
        return response()->json(Product::paginate(5));
    }

    public function store(Request $request)
    {
        $rules = array(
            "subject" => "required",
            "carmodel_id" => "required|exists:carmodels,id",
            "price" => "required|digits_between:1,10000000000",
            "year_id" => "required|exists:years,id",
            "attributes" => "required",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $data_product = $request->only(['subject', 'price', 'carmodel_id', 'year_id']);
            $data_attribute = $request->only(['attributes']);
            DB::beginTransaction();
            $product = Product::create($data_product);
            $options_data = [];
            foreach ($data_attribute["attributes"] as $key => $value) {
                $options_data[] = $value;
            }
            $product->Attrproducts()->createMany($options_data);
            DB::commit();
            return response()->json([$product->id, 'Product add successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, Request $request)
    {
        $rules = array(
            "subject" => "required",
            "carmodel_id" => "required|exists:carmodels,id",
            "price" => "required|digits_between:1,10000000000",
            "year_id" => "required|exists:years,id",
            "attributes" => "required",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $data_product = $request->only(['subject', 'price', 'carmodel_id', 'year_id']);
            $data_attribute = $request->only(['attributes']);
            DB::beginTransaction();
            $product = Product::findOrFail($id);
            $product->updateOrFail($data_product);

            $options_data = [];
            $product->Attrproducts()->forceDelete();

            foreach ($data_attribute["attributes"] as $key => $value) {
                $options_data[] = $value;
            }
            $product->Attrproducts()->createMany($options_data);
            DB::commit();
            return response()->json([$product->id, 'Product update successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function delete($id) {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($id);
            $product->Attrproducts()->forceDelete();
            $product->delete();
            DB::commit();

            return response()->json(['Product Delete successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }
}
