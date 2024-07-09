<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Input;
use Response;
use Auth;
use File;

use App\Module;
use App;

use App\Asset;

class UploadController extends Controller
{
    
    protected $uploadPath;
    
    public function __construct() {
        
        if (Auth::user()->check()) {
            
            $userId = Auth::user()->get()->id;

            $this->uploadPath = 'uploads/images/';

//            $this->uploadPath = 'uploads/' . $userId . '/';
//
//            if($userId == 1){
//                $this->uploadPath = 'uploads/admin/';
//            }
        }
    }
    
    public function upload() {
        
        
        if (!File::exists($this->uploadPath)) {
            File::makeDirectory($this->uploadPath);
        }
        
        $file = Input::file('file');

        $name = $file->getClientOriginalName();
        $fileName = time() . $name;
        
        $file->move($this->uploadPath, $fileName);
        
        $res = array(
            'fileName' => $fileName,
            'path' => $this->uploadPath
        );
        
        return Response::json($res);
        
    }

    /**
     * Save multiple entry to database
     * @param  Request $request
     * @internal param Module $module
     */
    public function saveMultipleImages(Request $request)
    {
        $data = $request->all();

//        $modelStr = $module->whereIdentifier($data['moduleIdentifier'])->pluck('model');

        $modelStr = $data['model'];

        $model = App::make($modelStr);

        $model->where($data['foreignKeyField'], $data['foreignKeyId'])->delete();

        /*Check if user selected a primary image*/
        $primaryMarked = 0;
        foreach ($data['images'] as $value) {
            if($value['primaryImage']){
                $primaryMarked = 1;
            }
        }

        foreach ($data['images'] as $key => $value) {

            /*If nothing is marked, make 0 index primary marked*/
            if($primaryMarked == 0){
                if($key == 0){
                    $value['primaryImage'] = 1;
                }
            }

            $d = [
                $data['foreignKeyField'] => $data['foreignKeyId'],
                'file_name' => $value['fileName'],
                'is_primary' => $value['primaryImage'],
                'path' => $this->uploadPath
            ];

            $model->create($d);
        }

    }


    /**
     * Delete image in server
     * @param Request $request
     * @internal param object $data contains fileName
     */
    public function deleteImage(Request $request)
    {

        $response = false;

        $data = $request->all();

        if (File::delete($this->uploadPath . '/' . $data['fileName'])){
            $response = true;
        }

        return Response::json($response);
    }

}
