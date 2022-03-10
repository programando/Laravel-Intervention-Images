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


 public function createForm(){
    return view('dropzone');
 }

  public function fileUpload(Request $req) {

    set_time_limit(0);
    if($req->hasfile('imageFile')) 
        foreach($req->file('imageFile') as $file){
        
            $name = $file->getClientOriginalName();
            $RealPath = $file->getRealPath();
            $this->resizeIndividialImage ( $name,$RealPath );
            $imgData[] = strtolower($name);  
        }

        return $imgData;

       //return back()->with('success', compact('imgData'));
}



  public function resizeIndividialImage( $Imagen, $RealPath  )
    {
 
        $Imagen = strtolower( $Imagen );

        $destinationPath = public_path('drako');

        $imgFile70  = Image::make( $RealPath  );
        $imgFile150 = Image::make( $RealPath  );
        $imgFile240 = Image::make( $RealPath  );
        $imgFile480 = Image::make( $RealPath  );
        $imgFile600 = Image::make( $RealPath  );
        $imgFile800 = Image::make( $RealPath  );
        //$imgFile900 = Image::make( $RealPath  );

    
        $this->ImageResize (  $imgFile70, 70,  $Imagen   ) ;
        $this->ImageResize (  $imgFile150, 150,  $Imagen ) ;
        $this->ImageResize (  $imgFile240, 240,  $Imagen ) ;
        $this->ImageResize (  $imgFile480, 480,  $Imagen ) ;
        $this->ImageResize (  $imgFile600, 600,  $Imagen ) ;
        $this->ImageResize (  $imgFile800, 800,  $Imagen ) ;

        //$this->ImageResize900x500 ( $imgFile900, 900,500,  $Imagen ) ;
    
        $destinationPath = public_path('/uploads');
 
    }





    public function resizeImage(Request $request)
    {
	    $this->validate($request, [
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:20480',
        ]);

        $image          =  ( $request->file('file') );
         
        $input['file']  =   $image->getClientOriginalName();
        $input['file'] = strtolower( $input['file']);

        $destinationPath = public_path('drako');

        $imgFile70  = Image::make($image->getRealPath());
        $imgFile150 = Image::make($image->getRealPath());
        $imgFile240 = Image::make($image->getRealPath());
        $imgFile480 = Image::make($image->getRealPath());
        $imgFile600 = Image::make($image->getRealPath());
        $imgFile800 = Image::make($image->getRealPath());
        $imgFile900 = Image::make($image->getRealPath());

    
        $this->ImageResize (  $imgFile70, 70, $input['file']   ) ;
        $this->ImageResize (  $imgFile150, 150, $input['file'] ) ;
        $this->ImageResize (  $imgFile240, 240, $input['file'] ) ;
        $this->ImageResize (  $imgFile480, 480, $input['file'] ) ;
        $this->ImageResize (  $imgFile600, 600, $input['file'] ) ;
        $this->ImageResize (  $imgFile800, 800, $input['file'] ) ;

        $this->ImageResize900x500 ( $imgFile900, 900,500, $input['file'] ) ;
    
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


        private function ImageResize900x500( $imgFile, $Ancho,$Alto,$NomFile  ){
        $Carpeta       = $Ancho .'x' .$Alto .'/';
        
        $FullPathImage = public_path('drako/').$Carpeta  .$NomFile ;
       
        
        $imgFile->resize($Ancho , $Alto , function ($constraint) {
		    $constraint->aspectRatio();
		})->save($FullPathImage);
 
     }


}