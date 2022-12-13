<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Img;
use App\Models\ImgType;

class ImgPostController extends Controller
{
    public function index(Request $request){
        $keywords = $request->key;
        $name = $request->name;
        $path = $request->path;
        $keyword = explode("-",$keywords);
        $DB_Img = new Img();
        $DB_Img->path = $path;
        $DB_Img->name = $name;
        $DB_Img->save();
        $my_type = array();
        $count=count($keyword);
        for ($i=0; $i<$count; $i++){
            if ($keyword[$i] == ""){
                continue;
            }
            $key = Type::where('title', '=', $keyword[$i])->first();
            if (is_null($key)){
                $DB_Type = new Type();
                $DB_Type->title = $keyword[$i];
                $DB_Type->save();
                array_push($my_type, $DB_Type->id);
            }else{
                array_push($my_type, $key->id);
            }
        }
        $count = count($my_type);
        for ($i=0; $i<$count; $i++){
            $DB_ImgType = new ImgType();
            $DB_ImgType->Img_id = $DB_Img->id;
            $DB_ImgType->type_id = $my_type[$i];
            $DB_ImgType->save();
        }
        return back();
    }
}
