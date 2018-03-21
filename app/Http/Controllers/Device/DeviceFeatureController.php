<?php

namespace App\Http\Controllers\Device;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use File;
use Carbon;
use App\DeviceFeatureImage;

class DeviceFeatureController extends Controller
{
    public function index()
    {

    }

    public function add()
    {

        $image = DeviceFeatureImage::first();
        return view('pages.deviceFeature.add', compact('image'));
    }

    public function store(Request $request)
    {

//        $rules = [
//            'exclusiveimage' => 'mimes:jpg,png,jpeg',
//            'longevityimage' => 'mimes:jpg,png,jpeg',
//            'shockimage' => 'mimes:jpg,png,jpeg',
//            'sizeimage' => 'mimes:jpg,png,jpeg',
//            'researchimage' => 'mimes:jpg,png,jpeg',
//            'websiteimage' => 'mimes:jpg,png,jpeg',
//            'urlimage' => 'mimes:jpg,png,jpeg',
//            'overallimage' => 'mimes:jpg,png,jpeg',
//            'performanceImage' => 'mimes:jpg,png,jpeg',
//        ];
//
//        $validator = Validator::make($request->all(), $rules);
//
//        if ($validator->fails()) {
//            return redirect()
//                ->back()
//                ->withErrors($validator);
//        }

        $data = array();

        if ($request->hasFile('exclusiveimage')) {

            $getimage = DeviceFeatureImage::value('exclusiveimage');

            if ($getimage) {
                $filename = public_path() . '/upload/devicefeature/' . $getimage;

                \File::delete($filename);
            }

            $icon = $request->file('exclusiveimage');

            $filename = 'exclusive-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();

            $icon->move('public/upload/devicefeature/', $filename);
            $data['exclusiveimage'] = $filename;
        }

        if ($request->file('longevityimage')) {

            $getimage = DeviceFeatureImage::value('longevityimage');

            if ($getimage) {
                $filename = public_path() . '/upload/devicefeature/' . $getimage;

                \File::delete($filename);
            }

            $icon = $request->file('longevityimage');

            $filename = 'longevity-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();

            $icon->move('public/upload/devicefeature/', $filename);
            $data['longevityimage'] = $filename;
        }


        if ($request->hasFile('shockimage')) {

            $getimage = DeviceFeatureImage::value('shockimage');

            if ($getimage) {
                $filename = public_path() . '/upload/devicefeature/' . $getimage;

                \File::delete($filename);
            }

            $icon = $request->file('shockimage');

            $filename = 'shock-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();

            $icon->move('public/upload/devicefeature/', $filename);
            $data['shockimage'] = $filename;
        }

        if ($request->hasFile('sizeimage')) {

            $getimage = DeviceFeatureImage::value('sizeimage');

            if ($getimage) {
                $filename = public_path() . '/upload/devicefeature/' . $getimage;

                \File::delete($filename);
            }

            $icon = $request->file('sizeimage');

            $filename = 'size-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();

            $icon->move('public/upload/devicefeature/', $filename);
            $data['sizeimage'] = $filename;
        }

        if ($request->hasFile('researchimage')) {

            $getimage = DeviceFeatureImage::value('researchimage');

            if ($getimage) {
                $filename = public_path() . '/upload/devicefeature/' . $getimage;

                \File::delete($filename);
            }

            $icon = $request->file('researchimage');

            $filename = 'research-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();

            $icon->move('public/upload/devicefeature/', $filename);
            $data['researchimage'] = $filename;
        }

        if ($request->hasFile('websiteimage')) {

            $getimage = DeviceFeatureImage::value('websiteimage');

            if ($getimage) {
                $filename = public_path() . '/upload/devicefeature/' . $getimage;

                \File::delete($filename);
            }

            $icon = $request->file('websiteimage');

            $filename = 'website-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();

            $icon->move('public/upload/devicefeature/', $filename);
            $data['websiteimage'] = $filename;
        }

        if ($request->hasFile('urlimage')) {

            $getimage = DeviceFeatureImage::value('urlimage');

            if ($getimage) {
                $filename = public_path() . '/upload/devicefeature/' . $getimage;

                \File::delete($filename);
            }

            $icon = $request->file('urlimage');

            $filename = 'url-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();

            $icon->move('public/upload/devicefeature/', $filename);
            $data['urlimage'] = $filename;
        }

        if ($request->hasFile('overallimage')) {

            $getimage = DeviceFeatureImage::value('overallimage');

            if ($getimage) {
                $filename = public_path() . '/upload/devicefeature/' . $getimage;

                \File::delete($filename);
            }

            $icon = $request->file('overallimage');

            $filename = 'overall-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();

            $icon->move('public/upload/devicefeature/', $filename);
            $data['overallimage'] = $filename;
        }

        if ($request->hasFile('performanceImage')) {

            $getimage = DeviceFeatureImage::value('performanceImage');

            if ($getimage) {
                $filename = public_path() . '/upload/devicefeature/' . $getimage;

                \File::delete($filename);
            }

            $icon = $request->file('performanceImage');

            $filename = 'performance-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();

            $icon->move('public/upload/devicefeature/', $filename);
            $data['performanceImage'] = $filename;
        }

        $getdata = DeviceFeatureImage::get();

        if (count($getdata) > 0) {
            $feature = DeviceFeatureImage::where('id', '1')->update($data);
        } else {
            $feature = new DeviceFeatureImage();
            $feature->fill($data);
            $feature->save();
        }

        return \redirect('admin/devices');


    }

}
