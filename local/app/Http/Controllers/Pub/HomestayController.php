<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HomeStay;
use App\Models\HomestayImage;
use Auth;
use File;
use App\Models\Facility;

class HomestayController extends Controller
{
	public function getYourHomestay(){
		return view('public.yourhomestay');
	}

	public function getBedroom(){
		return view('public.yourbedroom');
	}

	public function getLocation(){
		return view('public.yourlocation');
	}

	public function getYourPhoto(){
		return view('public.yourphoto');
	}
	
	public function getAddMoreRoom(){
		return view('public.add-room');
	}
	
	public function getAddHomestay(){
		$data['facility'] = Facility::all();
		return view('public.editHomestay',$data);
	}

	public function postEditHomestay(Request $request){
		$homestay = HomeStay::where('homestay_user_id', Auth::user() );
		$homestay->homestay_name = $request->homestay_name;
		$homestay->homestay_type = $request->homestay_type;
		$homestay->homestay_about = $request->homestay_about;

		if( $request->hasFile('homestay_image') ){
			$homestay->homestay_image = saveSingleImage( $request->homestay_image,200,'image/user-'.Auth::user()->id );
		}

		$homestay->homestay_location = $request->homestay_location;
		if( $request->homestay_facility != null ){
			$homestay->homestay_facility = implode('|',$request->homestay_facility);
		}
		$homestay->homestay_rule = $request->homestay_rule;
		
		dd($homestay);

		try{
			$homestay->save();
		}catch(\Exception $e){
			return back()->with('error','Đã có lỗi xảy ra vui lòng thử lại.');
		}
		return back();
	}

	public function getAddHomestayImage(){
		
	}

	public function postAddHomestayImage(Request $request){
		$image = new HomestayImage;
		$image->homestay_image_img = saveSingleImage( $request->homestay_image_img, 200, 'image/user-'.Auth::user()->id );
		$image->homestay_image_homestay_id = Auth::user()->id;
		$image->save();
		return 'b';
	}

	public function getDeleteHomestayImage($id){
		$filename = HomestayImage::find($id)->homestay_image;
		$path = 'local/storage/app/image/user-'.Auth::user()->id;
		if( File::exists($path.'/'.$filename) ){
			File::delete($path.'/'.$filename);
		}
		if( File::exists($path.'/resized-'.$filename) ){
			File::delete($path.'/resized-'.$filename);
		}
		HomestayImage::destroy($id);
		return back();
	}
}