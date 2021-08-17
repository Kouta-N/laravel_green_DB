<?php

namespace App\Http\Controllers;

use App\Http\Pagination\MyPaginator;
use App\MyClasses\MyService;
use App\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class HelloController extends Controller
{
    public function index(Request $request)
    {
        $msg = 'show people record.';
        $re = Person::get();
        $fields = Person::get()->fields();
        $data = [
            'msg' => implode(',',$fields),
            'data' => $re,
        ];
        return view('hello.index', $data);
    }

    public function save($id,$name)
    {
        $record = Person::find($id);
        $record->name = $name;
        $record->save();
        return redirect()->route('hello');
    }

    public function other()
    {
        $person = new Person();
        $person->all_data = ['aaa', 'bbb@ccc', 123];
        $person->save();
        return redirect()->route('hello');
    }


    /*map,filter
    public function index(Request $request)
    {
        $msg = 'show people record.';
        $even = Person::get()->filter(function($item)
        {
            return $item->id % 2 == 0;
        });
        $map = $even->map(function($item,$key)
        {
            return $item->id.':'.$item->name;
        });
        $data = [
            'msg' => $map,
            'data' => $even,
        ];
        return view('hello.index', $data);
    }
    */

    /*merge
    public function index(Request $request)
    {
        $msg = 'show people record.';
        $even = Person::get()->filter(function($item)
        {
            return $item->id % 2 == 0;
        });
        $even2 = Person::get()->filter(function($item)
        {
            return $item->age % 2 == 0;
        });
        $result = $even->merge($even2);
        $data = [
            'msg' => $msg,
            'data' => $result,
        ];
        return view('hello.index', $data);
    }
    */

    /*filter,reject
    public function index(Request $request)
    {
        $msg = 'show people record.';
        $result = Person::get()->filter(function($person)
        {
            return $person->age < 50;
            //下記でも同様の結果が得られる
            //return $person->age < 50 AND $person->age > 20;

        });
        $result2 = Person::get()->filter(function($person)
        {
            return $person->age < 20;
        });
        $result3 = $result->diff($result2);
        $data = [
            'msg' => $msg,
            'data' => $result3,
        ];
        return view('hello.index', $data);
    }
    */

    /*filter,reject
    public function index(Request $request)
    {
        $msg = 'show people record.';
        // $result = Person::get()->filter(function($person)
        $result = Person::get()->reject(function($person)
        {
            return $person->age > 20;
        });
        $data = [
            'msg' => $msg,
            'data' => $result,
        ];
        return view('hello.index', $data);
    }
    */

    /* pagenator
    public function index(Request $request)
    {
        $id = $request->query('page');
        $msg = 'show page: '.$id;
        $result = Person::paginate(3);
        $paginator = new MyPaginator($result);
        $data = [
            'msg' => $msg,
            'data' => $result,
            'paginator' => $paginator,
        ];
        return view('hello.index', $data);
    }
    */

    /*paginate
    public function index(Request $request)
    {
        $id = $request->query('page');
        $msg = 'show page: '.$id;
        $result = DB::table('people')->paginate(3,['*'],'page',$id);
        $data = [
            'msg' => $msg,
            'data' => $result,
        ];
        return view('hello.index', $data);
    }
    */

    /*pluck
    public function index()
    {
        $name = DB::table('people')->pluck('name');
        $value = $name->toArray();
        $msg = implode(',',$value);
        $result = DB::table('people')->get();
        $data = [
            'msg' => $msg,
            'data' => $result,
        ];
        return view('hello.index', $data);
    }
    */

    /* DB where&like
    public function index($id = -1)
    {
        if ($id >= 0) {
            $msg = 'get name like "' . $id . '".';
            $result = DB::table('people')->where('name','like','%' . $id . '%')->get();
        } else {
            $msg = 'get people records.';
            $result = DB::table('people')->get();
        }
        $data = [
            'msg' => $msg,
            'data' => $result,
        ];
        return view('hello.index', $data);
    }
    */

    /* DB where文
    public function index($id = -1)
    {
        if ($id >= 0) {
            $msg = 'get ID <= '.$id;
            $result = DB::table('people')->where('id', '<=', $id)->get();
        } else {
            $msg = 'get people records.';
            $result = DB::table('people')->get();
        }
        $data = [
            'msg' => $msg,
            'data' => $result,
        ];
        return view('hello.index', $data);
    }
    */

    /* DB get
    public function index()
    {
        $result = DB::table('people')->get();
        $data = [
            'msg' => 'Database access',
            'data' => $result,
        ];
        return view('hello.index', $data);
    }
    */

    /* singleton
    function __construct(MyService $my_service)
    {
        $my_service = app('App\MyClasses\MyService');
    }

    public function index(MyService $my_service,int $id = -1)
    {
        $my_service->setId($id);
        $data = [
            'msg' => $my_service->say($id),
            'data' => $my_service->alldata(),
        ];
        return view('hello.index', $data);
    }
    */

    /* クエリパラメータ
    public function index(Request $request,Response $response)
    {
        $name = $request->query('name');
        $mail = $request->query('mail');
        $tel = $request->query('tel');
        $msg = $request->query('msg');
        $keys = ['名前','メール','電話'];
        $values = [$name,$mail,$tel];
        $data = [
            'msg' => $msg,
            'keys' => $keys,
            'values' => $values,
        ];
        $request->flash();
        return view('hello.index', $data);
    }

    public function other()
    {
        $data = array(
            'name' => 'Taro',
            'mail' => 'taro@yamada',
            'tel' => '090-090-090',
        );
        $query_str = http_build_query($data);
        dd($query_str);
        $data['msg'] = $query_str;
        return redirect()->route('hello', $data);
    }
    */

    /*flash
    public function index(Request $request,Response $response)
    {
        $msg = 'please input text:';
        $keys = [];
        $values = [];
        if ($request->isMethod('post')) {
            $form = $request->only(['name','mail']);
            $keys = array_keys($form);
            $values = array_values($form);
            $msg = old('name').'<br>'.old('mail').'<br>'.old('tel');
            $data = [
            'msg' => $msg,
            'keys' => $keys,
            'values' => $values,
            ];
            // $request->flashOnly(['name','mail']);
            $request->flash();
            return view('hello.index', $data);
        }
        $data = [
            'msg' => $msg,
            'keys' => $keys,
            'values' => $values,
        ];
        return view('hello.index', $data);
    }
    */

    /* onlyによるキーの指定
    public function index(Request $request,Response $response)
    {
        $msg = 'please input text:';
        $keys = [];
        $values = [];
        if ($request->isMethod('post')) {
            $form = $request->only(['name','mail']);
            $keys = array_keys($form);
            $values = array_values($form);
            $data = [
            'msg' => $msg,
            'keys' => $keys,
            'values' => $values,
            ];
            return view('hello.index', $data);
        }
        $data = [
            'msg' => $msg,
            'keys' => $keys,
            'values' => $values,
        ];
        return view('hello.index', $data);
    }
    */

    /* 要素の属性、内容の出力
    public function index(Request $request,Response $response)
    {
        $msg = 'please input text:';
        $keys = [];
        $values = [];
        if ($request->isMethod('post')) {
            $form = $request->all();
            $keys = array_keys($form);
            //dd($keys);//要素の属性が出力される
            $values = array_values($form);
            //dd($values);//要素の内容が出力される
        }
        $data = [
            'msg' => $msg,
            'keys' => $keys,
            'values' => $values,
        ];
        return view('hello.index', $data);
    }
    */

    /* 複数要素のインプット
    public function index(Request $request)
    {
        $msg = 'please input text:';
        $keys = [];
        $values = [];
        if ($request->isMethod('post')) {
            $form = $request->all();
            $keys = array_keys($form);
            //dd($keys);//要素の属性が出力される
            $values = array_values($form);
            //dd($values);//要素の内容が出力される
        }
        $data = [
            'msg' => $msg,
            'keys' => $keys,
            'values' => $values,
        ];
        return view('hello.index', $data);
    }
    */

    /* Storage link
    private $fname;

    function __construct()
    {
        $this->fname = 'hello.txt';
    }

    public function index()
    {
        $sample_msg = Storage::disk('public')->url('hello.txt');
        $sample_data = Storage::disk('public')->get('hello.txt');
        $data = [
            'msg' => $sample_msg,
            'data' => explode(PHP_EOL,$sample_data),
        ];
        return view('hello.index', $data);
    }

    public function other($msg)
    {
        Storage::disk('public')->prepend($this->fname,$msg);
        return redirect()->route('hello');
    }
    */

    //configの実験
    // public function other(Request $request)
    // {
    //     $data = [
    //         'msg'=>$request->bye,
    //     ];
    //     return view('hello.index', $data);
    // }/ function __construct()
    // {
    //     config(['sample.message' => '新しいメッセージ !']);
    // }

    // public function index()
    // {
    //     $sample_msg = env('sample.message');
    //     $sample_data = config('sample.data');
    //     $data = [
    //         'msg' => $sample_msg,
    //         'data' => $sample_data,
    //     ];
    //     return view('hello.index', $data);
    // }

    // public function other(Request $request)
    // {
    //     return redirect()->route('sample');
    // }

    // public function other(Request $request)
    // {
    //     $data = [
    //         'msg'=>$request->bye,
    //     ];
    //     return view('hello.index', $data);
    // }

    // function __construct()
    // {
    //     config(['sample.message' => '新しいメッセージ !']);
    // }

    // public function index()
    // {
    //     $sample_msg = env('sample.message');
    //     $sample_data = config('sample.data');
    //     $data = [
    //         'msg' => $sample_msg,
    //         'data' => $sample_data,
    //     ];
    //     return view('hello.index', $data);
    // }

    // public function other(Request $request)
    // {
    //     return redirect()->route('sample');
    // }

    // public function other(Request $request)
    // {
    //     $data = [
    //         'msg'=>$request->bye,
    //     ];
    //     return view('hello.index', $data);
    // }

    /* モデルをルートパラメータにすることによるid取得
    public function index(Person $person)
    {
        $data = [
            'msg'=>$person,
        ];
        return view('hello.index', $data);
    }
    */

    /*
    public function index(Request $request)
    {
        $data = [
            'msg'=>$request->hello,
        ];

        return view('hello.index', $data);
    }
    */

    /*
    public function other(Request $request)
    {
        $data = [
            'msg'=>$request->bye,
        ];
        return view('hello.index', $data);
    }
    */
}