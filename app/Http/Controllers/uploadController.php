<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;	
use App\uploadModel;
class uploadController extends Controller
{
	public function __invoke(){

		return view('upload');
	}

	public function retrivePhoto(){
		$result =  uploadModel::get();
		return $result;
   }

	public function uploadPhoto(Request $request){
		$status = $request->input('status');
		// if($status=='paid'){
			// 	$storePath  = $request -> file('key')->store('paid');
			// 	$exactPath = substr($storePath, 5);
			// }elseif($status=='free'){
			// 	$storePath  = $request -> file('key')->store('free');
			// 	$exactPath = substr($storePath, 5);
		// }
		
		$storePath  = $request -> file('key')->store('images');
		$exactPath = substr($storePath, 7);
		$result = uploadModel::insert(['image'=>$exactPath,'status'=> $status]);
		return $exactPath;
   }


   public function deletePhoto(Request $request){

	$id = $request->input('id');
	$path = $request->input('path');
	$status = $request->input('status');
	if(Storage::delete("images/".$path)){
		$result = uploadModel::where('id',$id)->delete();
	}
	

	return $result;
}
}
