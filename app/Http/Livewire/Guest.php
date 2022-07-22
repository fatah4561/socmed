<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Hashtag;

class Guest extends Component
{
	use WithFileUploads;

    public $user_id, 
    $new_title, 
    $new_text, 
    $new_pic, 
    $new_hastag,
    $disabled,
    $posts,
    $search,
    $comments,
    $file_comments,
    $edit_post,
    $edit_post_id,
    $edit_comment_id,
    $edit_comment;

    public $posts_detail, 
    $hashtags, 
    $update_post_text, 
    $update_post_pic, 
    $update_comment_text, 
    $update_comment_pic = [];

    public function render()
    {
        return view('livewire.guest.home')->layout('livewire.guest.index')->section('body');
    }

    public function mount()
    {
        $this->disabled = false;
        $this->hastags = [];
        $this->edit_post = false;
        $this->edit_post_id = null;
        $this->edit_comment = false;
        $this->edit_comment_id = null;
        $this->postData();
        $this->refreshComment();
    }

    public function clear()
    {
        $this->disabled = false;
        $this->new_title = null;
        $this->new_text = null;
        $this->new_pic = null;
        $this->new_hastag = null;
        $this->edit_post = false;
        $this->edit_post_id = null;
        $this->edit_comment = false;
        $this->edit_comment_id = null;
        $this->postData();
        $this->refreshComment();
    }

    public function postData()
    {
        $this->posts = Post::orderBy('created_at', 'desc')->get();
        // dd(Carbon::parse($this->posts[0]->created_at)->diffForHumans());
        foreach ($this->posts as $post){
            $this->update_post_text[$post->id] = $post->text;
        }
    }

    public function refreshComment()
    {
        $this->comments = Comment::orderBy('created_at', 'asc')->get();
        foreach ($this->comments as $comment){
            $this->update_comment_text[$comment->id] = $comment->text;
        }
    }

    public function redirectLogin()
    {
        return redirect()->route('login');
    }

    public function searchHash()
    {
        if ($this->search == "" || $this->search == null ){
            $this->postData();
            $this->refreshComment();
        } else {
            $hashtags = Hashtag::where('tag', 'LIKE', '%' . $this->search . '%')->select('post_id', 'comment_id')->get();
            $searchPost = [];
            $searchComment = [];
            foreach($hashtags as $hashtag){
                if ($hashtag->post_id != null) {
                    array_push($searchPost, $hashtag->post_id);
                } 
                if ($hashtag->comment_id != null) {
                    array_push($searchComment, $hashtag->comment_id);
                }
            }
            $this->posts = Post::orderBy('created_at', 'desc')->whereIn('id', $searchPost)->get();
            $this->comments = Comment::orderBy('created_at', 'asc')->whereIn('id', $searchComment)->get();
            if (!empty($this->comments)){
                foreach($this->comments as $comment){
                    if ($comment->post_id != null) {
                        array_push($searchPost, $comment->post_id);
                    } 
                }
                $this->posts = Post::orderBy('created_at', 'desc')->whereIn('id', $searchPost)->get();
            }
        }
    }

    // private function
    private function getHashtags($string) { 
        $hashtags = null;
        preg_match_all("/(#\w+)/u", $string, $matches);  
        if ($matches) {
            $hashtags = $matches[0];
        }
        return $hashtags;
    }
}
