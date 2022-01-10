<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Image;

class ResizeController extends Controller
{
    
    public function index()
    {
    	return view('welcome');
    }

    public function resizeImage(Request $request)
    {
	    $this->validate($request, [
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:20480',
        ]);

        $image          = $request->file('file');
        $input['file']  = $image->getClientOriginalName();
        
        $destinationPath = public_path('drako');

        $imgFile70  = Image::make($image->getRealPath());
        $imgFile150 = Image::make($image->getRealPath());
        $imgFile240 = Image::make($image->getRealPath());
        $imgFile480 = Image::make($image->getRealPath());
        $imgFile600 = Image::make($image->getRealPath());
        $imgFile800 = Image::make($image->getRealPath());

    
        $this->ImageResize (  $imgFile70, 70, $input['file']   ) ;
        $this->ImageResize (  $imgFile150, 150, $input['file'] ) ;
        $this->ImageResize (  $imgFile240, 240, $input['file'] ) ;
        $this->ImageResize (  $imgFile480, 480, $input['file'] ) ;
        $this->ImageResize (  $imgFile600, 600, $input['file'] ) ;
        $this->ImageResize (  $imgFile800, 800, $input['file'] ) ;
    
        $destinationPath = public_path('/uploads');
        //$image->move($destinationPath, $input['file']);

        return back()
        	->with('success','Image has successfully uploaded.')
        	->with('fileName',$input['file']);
    }


        private function ImageResize( $imgFile, $Tamaño,$NomFile  ){
        $Carpeta       = $Tamaño .'x' .$Tamaño .'/';
        
        $FullPathImage = public_path('drako/').$Carpeta  .$NomFile ;
       
        
        $imgFile->resize($Tamaño , $Tamaño , function ($constraint) {
		    $constraint->aspectRatio();
		})->save($FullPathImage);
        
     }


}