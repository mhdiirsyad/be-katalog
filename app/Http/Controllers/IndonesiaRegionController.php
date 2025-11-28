<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class IndonesiaRegionController extends Controller
{
    public function getProvinces(){
        $provinces = Province::all();
        return response()->json([
            'data' => $provinces
        ], 201);
    }

    public function getCities($provinceCode) {
        $cities = City::query()
            ->where('province_code', $provinceCode)
            ->get();
        return response()->json([
            'data' => $cities
        ], 201);
    }

    public function getDistrics($cityCode) {
        $districts = District::query()
            ->where('city_code', $cityCode)
            ->get();
        return response()->json([
            'data' => $districts
        ], 201);
    }

    public function getVillages($districtCode) {
        $villages = Village::query()
            ->where('district_code', $districtCode)
            ->get();
        return response()->json([
            'data' => $villages
        ], 201);
    }
}
