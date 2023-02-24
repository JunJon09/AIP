<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Img;
use App\Models\ImgType;
use Illuminate\Support\Facades\Log;


class ImgPostController extends Controller
{
    public function index(Request $request){
        $noun = $request->input("noun");
        $name = $request->input("name");
        $adjective = $request->input("adjective");
        $path = $request->input("path");
        $keyword = explode("-",$noun);
        
        #Imgに挿入
        $id = $this->AddDBImg($path, $name);
        
        #Typeに挿入
        list($kind, $my_type) = $this->AddDBTypeNoun($keyword);

        #ImgTypeに挿入
        $this->AddDBImgType($my_type, $id);

        #形容詞についても同じ作業を行う
        $keyword = explode("-",$adjective);
        $my_type = $this->AddDBTypeAdjective($keyword);
        $this->AddDBImgType($my_type, $id);
        
        return $kind;
    }

    #Imgに挿入してID返す
    private function AddDBImg($path, $name){
        $DB_Img = new Img();
        $DB_Img->path = $path;
        $DB_Img->name = $name;
        $DB_Img->save();
        return $DB_Img->id;
    }

    #名詞のキーワードをTypeのDBに挿入して一番少ないキーワードを取得する
    private function AddDBTypeNoun($keyword){
        $count=count($keyword);
        $kind;
        $kind_count;
        $my_type = array();
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
        return array($kind, $my_type);
    }

    #形容詞のキーワードをTypeに挿入
    private function AddDBTypeAdjective($keyword){
        $count = count($keyword);
        $my_type = array();
        for($i=0; $i<$count; $i++){
            $key = Type::where('title', '=', $keyword[$i])->first();
            #DBにキーワードの有無
            if (is_null($key)){
                $DB_Type = new Type();
                $DB_Type->title = $keyword[$i];
                $DB_Type->count = 1;
                $DB_Type->save();
                array_push($my_type, $DB_Type->id);
            }else{
                $key->count += 1;
                $key->save();
                array_push($my_type, $key->id);
            }
        }
        return $my_type;
    }

    #ImgTypeに挿入
    private function AddDBImgType($my_type, $id){
        $count = count($my_type);
        for ($i=0; $i<$count; $i++){
            $DB_ImgType = new ImgType();
            $DB_ImgType->Img_id = $id;
            $DB_ImgType->type_id = $my_type[$i];
            $DB_ImgType->save();
        }
    }
}
