<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SortSliderController extends Controller
{
    public function sliders(Request $request)
    {
        $posicion = 1;
        $sorts = $request->get('sorts');

        foreach ($sorts as $sort) {
            $slider = Slider::find($sort);
            $slider->posicion = $posicion;
            $slider->save();

            $posicion++;
        }
    }
}
