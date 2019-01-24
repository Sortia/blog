<?php
/**
 * Created by PhpStorm.
 * User: kav
 * Date: 25.12.2018
 * Time: 13:03
 */

namespace App\Http\Controllers;

use App\Comments;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class MainController extends Controller
{
    protected $connection = "bb";

    private $categories = [
        'it' => '1',
        'books' => '2',
        'travel' => '3',
        'space' => '4',
        'politic' => '5',
        'auto' => '6',
    ];

    private $title_categories = [
        'it' => 'IT',
        'books' => 'Книги',
        'travel' => 'Путешествия',
        'space' => 'Космос',
        'politic' => 'Политика',
        'auto' => 'Авто',
    ];

    public function getMainPage()
    {

        $posts = Post::on($this->connection)->with('category')->orderBy("id", "desc")->paginate(10);
//        $posts1 = Post::on($this->connection)->with('category')->orderBy("id", "desc")->paginate(6);
        $best_posts = Post::on($this->connection)->orderBy("count_views", 'desc')->limit(6)->with('category')->get()->toArray();

//        dd($posts, $posts1);

        foreach ($posts as &$value) {
            $value["text_preview"] = substr($value["text"], 0, 200) . "...";
//            $value["text_preview"] = "...";
        }


        foreach ($best_posts as &$value) {
            $value["text_preview"] = substr($value["text"], 0, 100) . "...";
        }

        return view('main', ['title' => 'Новое', "posts" => $posts, "best_posts" => $best_posts]);
    }

    public function getPostsByCategory($category)
    {
        $posts = Post::on($this->connection)->with('category')->where('category_id', $this->categories[$category])->orderBy("id", "desc")->paginate(10);
        $best_posts = Post::on($this->connection)->with('category')->orderBy("count_views")->limit(6)->get()->toArray();
        $title = $this->title_categories[$category];

        foreach ($posts as &$value) {
            $value["text_preview"] = substr($value["text"], 0, 200) . "...";
        }

        foreach ($best_posts as &$value) {
            $value["text_preview"] = substr($value["text"], 0, 100) . "...";
        }

        return view('main', ['title' => $title,"posts" => $posts, "best_posts" => $best_posts]);
    }

    public function getPost($id)
    {
        $post = Post::on($this->connection)->with('comments')->where('id', $id)->first();
        $post->count_views++;
        $post->save();
        $post->where('id', $id)->first()->get();
        $post = $post->toArray();

       // $post['text'] = htmlspecialchars_decode($post['text']);

        $best_posts = Post::on($this->connection)->with('category')->orderBy("count_views")->limit(6)->get()->toArray();

        foreach ($best_posts as &$value) {
            $value["text_preview"] = substr($value["text"], 0, 100) . "...";
        }

        foreach ($post['comments'] as &$value) {
            $value['user'] = $value['user']['name'];
        }

        $post['count_comments'] = $this->getCountComments($post);
        //$user = Auth::user()->get()->pluck('name')->toArray()[0];

        return view('post', ["post" => $post, "best_posts" => $best_posts]);
    }


    public function addComment($id, Request $request)
    {
        $text = $request["comment"];
        $user_id = Auth::user()->getAuthIdentifier();

        $comment = new Comments;
        $comment->text = $text;
        $comment->post_id = $id;
        $comment->user_id = $user_id;
        $comment->save();

        $data['date'] = date('H:i:s d.m.Y');
        $data['text'] = $text;
        $data['user'] = Auth::user()->get()->pluck('name')->toArray()[0];

        return response()->json($data);
    }

    private function getCountComments($post)
    {
        $count_comments = count($post['comments']);
        $last_num = substr((String) $count_comments, -1);

        if($count_comments === 0)
            return "Оставьте комментарий первым";

        switch($last_num) {
            case '1': return count($post['comments']) . ' комментарий';
                break;
            case '2' || '3' || '4': return count($post['comments']) . ' комментария';
                break;
            case '5' || '6' || '7' || '8' || '9' || '0': return count($post['comments']) . ' комментариев';
                break;
            default: return '-11';
        }
    }

    public function add_post()
    {
        return view('new_post', ['categories' => $this->title_categories]);
    }

    public function save_new_post(Request $request)
    {
        $title = $request['title'];
        $text = $request['text'];
        $category = $request['category'];

        $new_post = new Post();
        $new_post['title'] = $title;
        $new_post['text'] = $text;
        $new_post['search_text'] = strip_tags($text);
        $new_post['category_id'] = $this->categories[$category];
        $new_post['user_id'] = Auth::user()->getAuthIdentifier();
        $new_post['path_image'] = 'undefined.jpg';
        $new_post->save();

        return response()->json($new_post->id);
    }

    public function save_new_post_image($id, Request $request)
    {
        if (isset($request->file()[0])) {
            $imgName = $id . '.jpg';
            $file = $request->file()[0];
            $file->move(public_path() . '/images', $imgName);

            Post::on($this->connection)->where('id', $id)->update(['path_image' => $imgName]);
        }
    }

    private function getBestPosts()
    {
        $best_posts = Post::on($this->connection)->with('category')->orderBy("count_views")->limit(6)->get()->toArray();

        foreach ($best_posts as &$value)
            $value["text_preview"] = substr($value["text"], 0, 100) . "...";

        return $best_posts;
    }

    public function searchPosts()
    {
        $search_text = '%' . Input::get('search') . '%';
        $posts = Post::on($this->connection)->where('text', 'ILIKE', $search_text)->paginate(12);
        $best_posts = $this->getBestPosts();

        foreach ($posts as &$value)
            $value["text_preview"] = substr($value["text"], 0, 100) . "...";

        return view('main', ['title' => 'Найдено',"posts" => $posts, "best_posts" => $best_posts]);
    }


    public function deletePost($id)
    {
        Post::on($this->connection)->where('id', $id)->delete();

        return response()->json(true);
    }

    public function deleteComment($id)
    {
        Comments::on($this->connection)->where('id', $id)->delete();

        return response()->json(true);
    }
}





























