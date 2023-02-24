<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Img;
use App\Models\ImgType;

class ImgPostController extends Controller
{
    public function index($keywords, $name, $path){
        $keyword = explode("-",$keywords);
        $DB_Img = new Img();
        $DB_Img->path = $path;
        $DB_Img->name = $name;
        $DB_Img->save();
        $my_type = array();
        $count=count($keyword);
        $kind;
        $kind_count;
        for ($i=0; $i<$count; $i++){
            if ($keyword[$i] == ""){
                continue;
            }
            $key = Type::where('title', '=', $keyword[$i])->first();
            #DBにキーワードの有無
            if (is_null($key)){
                $DB_Type = new Type();
                $DB_Type->title = $keyword[$i];
                $DB_Type->count = 1;
                $DB_Type->save();
                array_push($my_type, $DB_Type->id);
                if ($i == 0){ #初期値設定
                    $kind = $keyword[$i];
                    $kind_count = 1;
                }
            }else{
                $key->count += 1;
                $key->save();
                array_push($my_type, $key->id);
                if ($i == 0){ #初期値設定
                    $kind = $keyword[$i];
                    $kind_count = $key->count;
                }else{
                    if ($kind_count > $key->count){ #種類のカウントが一番多いのを採用
                        $kind = $keyword[$i];
                        $kind_count = $key->count;
                    }
                }
            }
        }

        $count = count($my_type);
        for ($i=0; $i<$count; $i++){
            $DB_ImgType = new ImgType();
            $DB_ImgType->Img_id = $DB_Img->id;
            $DB_ImgType->type_id = $my_type[$i];
            $DB_ImgType->save();
        }
        //DBの中で一番少ない名詞を返す
        return $kind;
    }
}
