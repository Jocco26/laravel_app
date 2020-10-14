<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;


class ContentsController extends Controller
{
    //
    public function home(Request $request)
    {
        $data = [];
        $data['version'] = '0.1.2';

        //?-> checking if session last_updated has value
        $last_updated = $request->session()->has('last_updated') ?
        //if yes pull the value            //if not = 'none'
        $request->session()->pull('last_updated') : 'none';
        //storing it in data array
        $data['last_updated'] = $last_updated;
        return view('contents/bahay', $data);
    }

    
    //image uploading function
    
    public function upload(Request $request)
        {
            $data = [];
            if( $request->isMethod('post') )
            {
                

                /*

                $extension = $request->file('image_upload')->getClientOriginalExtension();

                $fileNameToStore= 'home_img'.'.'.$extension;
                
                
                if(Storage::disk('public')->exists('attractions.jpg'))
                {
                   
                    Storage::delete('public/home_img.jpg');
                    $request->file('image_upload')->storeAs('public/', $fileNameToStore);
                    return redirect('/');
                }                  
                else{
                    $request->file('image_upload')->storeAs('public/', $fileNameToStore);
                    return redirect('/');
                }
                */
                    
                $this->validate(
                    $request,
                    [
                        'image_upload' => 'mimes:jpeg,bmp,png'
                    ]
                );
                Input::file('image_upload')->move('images', 'home_img.jpg');
                return redirect('/');

            }
            return view('contents/upload', $data);
        }
    
}
