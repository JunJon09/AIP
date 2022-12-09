<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use App\Models\Img;
use App\Models\ImgType;
use Illuminate\Support\Facades\Log;

class ViewController extends Controller
{
    public function index(Request $request){
        $word = $request->word;
        Log::debug($word);
        return view('view', compact('word'));
    }
    
    public function fetch(Request $request) {
        $decodedFetchedImgIdList = json_decode($request->fetchedImgIdList, true);  #jsonをPHPの配列にしている。
        if (json_last_error() !== JSON_ERROR_NONE) { //直近のエラーが起きた時にエラーメッセージとして返している。
            return response()->json(['errorMessage' => json_last_error_msg()],500);
        }
        $img = $this->extractShowImgs($decodedFetchedImgIdList, $request->page, $request->word);
        return response()->json(['imgs' => $img], 200);
    }

    public function extractShowImgs($fetchedImgIdList, $page, $key)
    {
        $limit = 10; // 一度に取得する件数
        $offset = $page * $limit; // 現在の取得開始位置
        $imgs = array();
        $photos = array();
        $keys = explode(" ", $key);
        if (count($keys) == 1){
            $type = Type::where('title', '=', $key)->first();
            if (!(is_null($type))){
                $imgType = ImgType::where('type_id', '=', $type->id)->skip($offset)->take($limit)->get();
                $count =count($imgType);
                for ($i=0; $i<$count; $i++){
                    $path = Img::where('id', $imgType[$i]->Img_id)->first()->path;
                    array_push($imgs, $path);
                }
            }
        }else{ //keyが二つ以上の時
            $type_id = array();
            $count = count($keys);
            for($i=0; $i<$count; $i++){ //typeid取得
                $type = Type::where('title', '=', $keys[$i])->first();
                if (!(is_null($type))){
                    array_push($type_id, $type->id);
                }
            }
            $word = ImgType::whereIn('type_id', $type_id)->selectRaw('Img_id, COUNT(Img_id)')->groupBy('Img_id')->orderBy("COUNT(Img_id)", 'desc')->skip($offset)->take($limit)->get();
            $count = count($word);
            for ($i=0; $i<$count; $i++){
                $path = Img::where('id', $word[$i]->Img_id)->first()->path;
                array_push($imgs, $path);
            }
        }
        if (is_null($imgs)) {
            return [];
        }
        

        if (is_null($fetchedImgIdList)) {
           return $imgs;
        }

        $showableImgs = [];
        foreach ($imgs as $img) {
            if (!in_array($img, $fetchedImgIdList)) {
                $showableImgs[] = $img;
            }
        }
        
        return $showableImgs;
    }
}   
