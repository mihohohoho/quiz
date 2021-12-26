<?php

namespace App\Http\Controllers;

use App\Tag; 
use App\Quiz;
use Illuminate\Http\Request; 
use Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SearchController extends Controller
{   
    //タグ検索ページへ飛ぶ
    public function search(Request $request,Quiz $quiz)
    { 
        
        return view('quizzes/search');
        
    }
    
    
    //タグ検索機能
    public function searchtags(Request $request,Quiz $quiz)
    {   $keyword = $request->input("keyword");
        $query = Quiz::query();
        $quizzes = Quiz::whereHas('tags', function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        })->get();
        
        /*//ページネイトの定義
        function getPaginateByLimit(int $limit_count = 10)
        {
            // updated_atで降順に並べたあと、limitで件数制限をかける
            return $quizzes->orderBy('updated_at', 'DESC')->paginate($limit_count);
        }
        getPaginateByLimit();*/
        
        return view('quizzes/search', ["quizzes" => $quizzes, "keyword" => $keyword]);
        
    }
    
    //タグ一覧機能
    public function tags(Request $request,Quiz $quiz,Tag $tag)
    {   $quizzes=$tag->quizzes()->orderByDesc('created_at')->paginate(6);;
        $keyword=$tag['name'];
        return view('quizzes/search', ["quizzes" => $quizzes, "keyword" => $keyword]);
    }
    
    
    public function select_index(Request $request,Quiz $quiz)
    {   
        
        $catedory=$request->input("category");
        $level=$request->input("level");
        $quizzes = Quiz::where('category_id', $catedory)->where('level_id', $level)->orderByDesc('created_at')->paginate(6);
        
        
        // クライアントインスタンス生成
        $client = new \GuzzleHttp\Client();

        // GET通信するURL
        $url = "https://newsapi.org/v2/everything?q='韓国'&pageSize=7&apiKey=b8988c840ad844b3865c306980004138";

        // リクエスト送信と返却データの取得
        // Bearerトークンにアクセストークンを指定して認証を行う
        $response = $client->request(
            'GET',
            $url,
        );
        // API通信で取得したデータはjson形式なので
        // PHPファイルに対応した連想配列にデコードする
        $articles = json_decode($response->getBody(), true);
        return view('quizzes/select')->with(["quizzes" => $quizzes,"articles" => $articles['articles']]);
        
        
    }
}
