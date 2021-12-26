<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\User;
use App\Tag;
use App\Rank;
use Auth;
use App\Http\Requests\QuizRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Storage;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    //ウェルカム画面
    public function welcome()
    {   
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
        
        $record=intval(count(Auth::user()->records)/10);
        $rank=Rank::where('judge',$record)->first();
        
            return view('quizzes/welcome')->with(['articles' => $articles['articles'],'rank'=>$rank]);
    }
    
    //index.bladeにpostの内容を制限した分だけ渡す＋ページネイト機能をつける処理
   public function index(Quiz $quiz)
    {   
        return view('quizzes/index')->with(['quizzes' => $quiz->getPaginateByLimit()]);
    } 
    
        /**
     * 特定IDのpostを表示する
     *
     * @params Object Post // 引数の$postはid=1のPostインスタンス
     * @return Reposnse post view
     */
    public function show(Quiz $quiz)
    {
        return view('quizzes/show',compact('quiz'));
    }
    
    public function create()
    {
        return view('quizzes/create');
    }
    
    //ユーザからのリクエストに含まれるデータを扱う場合、Requestインスタンスを利用
    public function store(QuizRequest $request, Quiz $quiz, Tag $tag)
    {
        //quizをキーに持つリクエストパラメータを取得
        $input = $request['quiz'];
        //user_idのキーにUserインスタンスのidプロパティを持たせ、inputに追加
        $input += ['user_id' => $request->user()->id];
        
        //quizテーブルにデータを入力（fill）、追加（save）＊$quiz->create($input)としても同じ挙動
        $quiz->fill($input);
        
        //画像をファイルに保存する処理
        if (!empty($input['image'])){
        $image=$input['image'];
        $path = Storage::disk('s3')->putFile('quizzes', $image, 'public');
          // アップロードした画像のフルパスを取得
          $quiz->image = Storage::disk('s3')->url($path);
        }
          $quiz->save();
        
        //タグづけ機能
        // #(ハッシュタグ)で始まる単語を取得。結果は、$matchに多次元配列で代入される。
        preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $request->tags, $match);
        // $match[0]に#(ハッシュタグ)あり、$match[1]に#(ハッシュタグ)なしの結果が入ってくるので、$match[1]で#(ハッシュタグ)なしの結果のみを使います。
        $tags = [];
        
        foreach ($match[1] as $tag) {
        $record = Tag::firstOrCreate(['name' => $tag]);// firstOrCreateメソッドで、tags_tableのnameカラムに該当のない$tagは新規登録される。
        array_push($tags, $record);// $recordを配列に追加します(=$tags)
        $tag_id=Tag::where('name',$tag)->get(['id']);
        $quiz->tags()->syncWithoutDetaching($tag_id);
        }
        
        //処理が終わったら直ちに以下のURL(ブログ詳細画面に飛ぶs)に再接続
        return redirect('/quizzes/' . $quiz->id);
    }
    
    //求められた編集元のデータを渡す処理
    public function edit(Quiz $quiz)
    {
        return view('quizzes/edit')->with(['quiz' => $quiz]);
    }
    
    //データの上書き実行
    public function update(QuizRequest $request, Quiz $quiz)
    {
        $input_quiz = $request['quiz'];
        //user_idのキーにUserインスタンスのidプロパティを持たせる
        $input_quiz += ['user_id' => $request->user()->id];
        $quiz->fill($input_quiz);
        
       //画像をファイルに保存する処理
        if (!empty($input['image'])){
        $image=$input['image'];
        $path = Storage::disk('s3')->putFile('quizzes', $image, 'public');
          // アップロードした画像のフルパスを取得
          $quiz->image = Storage::disk('s3')->url($path);
        }
          $quiz->save();
        
        //タグづけ機能
        // #(ハッシュタグ)で始まる単語を取得。結果は、$matchに多次元配列で代入される。
        preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $request->tags, $match);
        // $match[0]に#(ハッシュタグ)あり、$match[1]に#(ハッシュタグ)なしの結果が入ってくるので、$match[1]で#(ハッシュタグ)なしの結果のみを使います。
        $tags = [];
        foreach ($match[1] as $tag) {
        $record = Tag::firstOrCreate(['name' => $tag]);// firstOrCreateメソッドで、tags_tableのnameカラムに該当のない$tagは新規登録される。
        array_push($tags, $record);// $recordを配列に追加します(=$tags)
        $tag_id=Tag::where('name',$tag)->get(['id']);
        $quiz->tags()->syncWithoutDetaching($tag_id);
        }
        
        return redirect('/quizzes/' . $quiz->id);
    }
     //データ削除実行
    public function delete(Quiz $quiz)
    {
        $quiz->delete();
        return redirect('/');
    }
    //クイズ回答ページへ飛ぶ
    public function play(Quiz $quiz)
    {  
        return view('quizzes/play',compact('quiz'));
    }
    //クイズ解説ページへ飛ぶ
    public function answer(Quiz $quiz)
    {   
        
        if (!isset($_POST['answer'])) {
        $error = array();
        return redirect('/quizzes/' . $quiz->id.'/play')->with([$error]);
        }
        if ($_POST['answer']==$quiz['choice1']) {
        $quiz->points()->detach(Auth::id());
        $quiz->points()->attach(Auth::id());
        
        }
        $quiz->records()->detach(Auth::id());
        $quiz->records()->attach(Auth::id());
        return view('quizzes/answer',compact('quiz'));
    }
    
    //ランダムクイズ機能
    public function random(Quiz $quiz)
    {  
        $quiz = Quiz::inRandomOrder()->take(1)->first();
        
        return view('quizzes/play')->with(['quiz' => $quiz]);
    }
    
    //マイページ
    public function user_page(Quiz $quiz)
    {   // クライアントインスタンス生成
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
        
        $record=intval(count(Auth::user()->records)/10);
        $rank=Rank::where('judge',$record)->first();
        $user = Auth::user();
        return view('quizzes/user_page')->with(['articles' => $articles['articles'],'user' =>$user,'rank'=>$rank]);
    }
    
    //マイページ：いいね 一覧
    public function user_liked(Quiz $quiz,User $user)
    {   
        $quizzes=$user->likes()->orderByDesc('created_at')->paginate(6);
        return view('quizzes/user_liked')->with(['quizzes' => $quizzes]);
    }
    
    
    //マイページ：制作クイズ一覧
    public function user_created(Quiz $quiz,User $user)
    {   $quizzes=$user->quizzes()->orderByDesc('created_at')->paginate(6);
        return view('quizzes/user_created')->with(['quizzes' => $quizzes]);
    }
    
    //マイページ：クイズ回答履歴 一覧
    public function user_records(Quiz $quiz,User $user)
    {   
        $quizzes=$user->records()->orderByDesc('created_at')->paginate(6);
        return view('quizzes/user_records')->with(['quizzes' => $quizzes]);
    }
    
    //ジャンル・レベルでクイズを選ぶ画面へ
    public function select(Quiz $quiz)
    {   
        
        
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
        return view('quizzes/select')->with(['articles' => $articles['articles']]);
    }
    
    
    
}
