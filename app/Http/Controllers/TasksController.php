<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task; // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 認証済みorNOTで挙動を変える
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // タスク一覧を取得
            // $tasks = $user->Task::orderBy('id', 'desc')->paginate(25);
            $tasks = $user->tasks()->orderBy('id', 'desc')->paginate(25);
        
            // タスク一覧ビューでそれを表示
            return view('tasks.index', [
                'tasks' => $tasks,
            ]);
            
        } else {
            // top pageへリダイレクトさせる
            // return back(); ng
            return view('welcome'); // view(表示)のみ
            // return redirect('welcome'); ng
            // return redirect('/'); ng
        };
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;

        // タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);
        
        // タスクを作成
        // $task = new Task;
        // $task->status = $request->status;    // 追加
        // $task->content = $request->content;
        // $task->save();
        
        // 認証済みユーザのタスクとして作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        
        // トップページへリダイレクトさせる
        return redirect('/');
        // 前のページへリダイレクト
        // return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済みユーザがそのタスクの所有者である場合は、投稿を表示
        if (\Auth::id() === $task->user_id) {
            // タスク詳細ビューでそれを表示
            return view('tasks.show', [
                'task' => $task,
            ]);
        // 認証できなければ、トップページへ戻る
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済みユーザがそのタスクの所有者である場合は、タスクを取得
        if (\Auth::id() === $task->user_id) {
            
            // タスク編集ビューでそれを表示
            return view('tasks.edit', [
                'task' => $task,
            ]);
        // 認証できなければ、トップページへ戻る
        } else {
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);
        
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済みユーザがそのタスクの所有者である場合は、タスクを取得
        if (\Auth::id() === $task->user_id) {
            
            // タスクを更新
            $task->status = $request->status;    // 追加
            $task->content = $request->content;
            $task->save();

            // トップページへリダイレクトさせる
            return redirect('/');
        } else {
             // トップページへリダイレクトさせる
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id); // 有効化
        // タスクを削除
        // $task->delete();
        
        // 認証済みユーザがそのタスクの所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        } else {
            return redirect('/');
        }

        // トップページへリダイレクトさせる ログインユーザの場合、一覧画面へ遷移
        return redirect('/');
    }
}
