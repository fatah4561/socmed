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


class Dashboard extends Component
{
	use WithFileUploads;
    /**
     * inisialisasi data kosong
     */
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

    /**
     * render() ialah function yang digunakan untuk mereturn view
     */
    public function render()
    {
        return view('livewire.dashboard.home')->layout('livewire.dashboard.index')->section('body');
    }

    /**
     * mount() ialah function yang dijalankan 1x ketika halaman dibuka,
     * mount akan mengisikan variabel dengan nilai yang diinginkan (inisialisasi data)
     */
    public function mount()
    {
        $this->disabled = false;
        $this->hastags = [];
        $this->user_id = Auth::user()->id;
        $this->edit_post = false;
        $this->edit_post_id = null;
        $this->edit_comment = false;
        $this->edit_comment_id = null;
        $this->postData();
        $this->refreshComment();
    }

    /**
     * clear() function yang digunakan untuk mereset inputan dan merefresh data posingan
     * dan data komentar yang ditampilkan
     */
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

    /**
     * post() function untuk membuat data postingan (create post)
     */
    public function post()
    {
        $stored_path = null;
        $today = Carbon::now()->format('YmdHis');

        if($this->new_pic){
            $exists_file = Storage::files(Storage::url($this->new_pic));
            if($exists_file){
                Storage::delete($this->picture);
            }

            $filename = $today."_post_".$this->user_id;
            $file_extension = explode('.' , $this->new_pic->getClientOriginalName())[1];
            $stored_path = $this->new_pic->storePubliclyAs('uploads/user/posts', $filename.".".$file_extension, 'public');
        }

        $post = Post::create([
            'user_id' => $this->user_id,
            'text' => $this->new_text,
            'picture' => $stored_path,
        ]);

        $hashtags = $this->getHashtags($post->text);

        foreach($hashtags as $hashtag){
            $new_hashtag = Hashtag::create([
                "post_id" => $post->id,
                "comment_id" => null,
                "tag" => $hashtag,
            ]);
        }
        $this->clear();
        session()->flash('message', 'Post anda telah dibuat.');
    }

    /**
     * postData() function untuk mendapatkan data postingan (get all post)
     */
    public function postData()
    {
        $this->posts = Post::orderBy('created_at', 'desc')->get();
        // dd(Carbon::parse($this->posts[0]->created_at)->diffForHumans());
        foreach ($this->posts as $post){
            $this->update_post_text[$post->id] = $post->text;
        }
    }

    /**
     * refreshComment() function untuk mendapatkan data komentar (get all comment)
     */
    public function refreshComment()
    {
        $this->comments = Comment::orderBy('created_at', 'asc')->get();
        foreach ($this->comments as $comment){
            $this->update_comment_text[$comment->id] = $comment->text;
        }
    }

    /**
     * comment() function untuk membuat data comment (create comment)
     * memerlukan parameter id postingan sebagai foreign key ke parentnya
     */
    public function comment($post_id)
    {
        $stored_path = null;

        if(isset($this->file_comments[$post_id])){
            $exists_file = Storage::files(Storage::url($this->file_comments[$post_id]));
            if($exists_file){
                Storage::delete($this->picture);
            }

            $filename = $this->posts_detail[$post_id]."_comment_".$this->user_id;
            $file_extension = explode('.' , $this->file_comments[$post_id]->getClientOriginalName())[1];
            $stored_path = $this->file_comments[$post_id]->storePubliclyAs('uploads/user/comments', $filename.".".$file_extension, 'public');
        }

        $comment = Comment::create([
            'user_id' => $this->user_id,
            'post_id' => $post_id,
            'text' => $this->posts_detail[$post_id],
            'picture' => $stored_path,
        ]);
        $hashtags = $this->getHashtags($comment->text);
        foreach($hashtags as $hashtag){
            $new_hashtag = Hashtag::create([
                "post_id" => null,
                "comment_id" => $comment->id,
                "tag" => $hashtag,
            ]);
        }
        $this->posts_detail[$post_id] = null;
        $this->file_comments[$post_id] = null;
        $this->refreshComment();

    }

    /**
     * searchHash() function untuk mencari (fitur search) berdasarkan hashtag yang diisikan pada
     * inputan search
     */
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

    /**
     * editPost() function untuk membuat program dalam edit mode pada postingan
     * yang diinginkan dengan parameter id postingan tersebut
     * edit mode hanya dapat dilakukan untuk user yang sudah login dan
     * pada postingan yang user tersebut buat sendiri
     */
    public function editPost($post_id)
    {
        $this->edit_post = true;
        $this->edit_post_id = $post_id;
        $post = Post::where('id', $post_id)->first();
        $this->update_post_text[$post_id] = $post->text;
    }

    /**
     * editComment() function untuk membuat program dalam edit mode pada komentar
     * yang diinginkan dengan parameter id komentar tersebut
     * edit mode hanya dapat dilakukan untuk user yang sudah login dan
     * pada postingan yang user tersebut buat sendiri
     */
    public function editComment($comment_id)
    {
        $this->edit_comment = true;
        $this->edit_comment_id = $comment_id;
        $comment = Comment::where('id', $comment_id)->first();
        $this->update_comment_text[$comment_id] = $comment->text;
    }

    /**
     * updatePost() function untuk mengubah data post yang diinginkan
     * menggunakan id postingan sebagai parameter
     */
    public function updatePost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        // upload
        $stored_path = null;
        $today = Carbon::now()->format('YmdHis');

        if(isset($this->update_post_pic[$post_id])){
            $exists_file = Storage::files(Storage::url($this->update_post_pic[$post_id]));
            if($exists_file){
                Storage::delete($this->picture);
            }

            $filename = $today."_post_".$this->user_id;
            $file_extension = explode('.' , $this->update_post_pic[$post_id]->getClientOriginalName())[1];
            $stored_path = $this->update_post_pic[$post_id]->storePubliclyAs('uploads/user/posts', $filename.".".$file_extension, 'public');
        }
        // update
        $post->update([
            "text" => $this->update_post_text[$post_id],
            "picture" => $stored_path,
        ]);
        $post->save();
        // hashtags
        $hashtags = Hashtag::where('post_id', $post_id)->delete();
        $hashtags = $this->getHashtags($this->update_post_text[$post_id]);
        foreach($hashtags as $hashtag){
            $new_hashtag = Hashtag::create([
                "post_id" => $post->id,
                "comment_id" => null,
                "tag" => $hashtag,
            ]);
        }
        $this->update_post_text[$post_id] = null;
        $this->update_post_pic[$post_id] = null;
        $this->clear();
    }

    /**
     * updateComment() function untuk mengubah data komentar yang diinginkan
     * menggunakan id komentar sebagai parameter
     */
    public function updateComment($comment_id)
    {
        $comment = Comment::where('id', $comment_id)->first();
        // upload
        $stored_path = null;
        $today = Carbon::now()->format('YmdHis');

        if(isset($this->update_comment_pic[$comment_id])){
            $exists_file = Storage::files(Storage::url($this->update_comment_pic[$comment_id]));
            if($exists_file){
                Storage::delete($this->picture);
            }

            $filename = $today."_comment_".$this->user_id;
            $file_extension = explode('.' , $this->update_comment_pic[$comment_id]->getClientOriginalName())[1];
            $stored_path = $this->update_comment_pic[$comment_id]->storePubliclyAs('uploads/user/comments', $filename.".".$file_extension, 'public');
        }
        // update
        $comment->update([
            "text" => $this->update_comment_text[$comment_id],
            "picture" => $stored_path,
        ]);
        $comment->save();
        // hashtags
        $hashtags = Hashtag::where('comment_id', $comment_id)->delete();
        $hashtags = $this->getHashtags($this->update_comment_text[$comment_id]);
        foreach($hashtags as $hashtag){
            $new_hashtag = Hashtag::create([
                "post_id" => null,
                "comment_id" => $comment->id,
                "tag" => $hashtag,
            ]);
        }
        $this->update_comment_text[$comment_id] = null;
        $this->update_comment_pic[$comment_id] = null;
        $this->clear();
    }
    /**
     * destroyPost() function untuk menghapus data post yang diinginkan
     * memerlukan parameter id postingan dan user harus login dan merupakan
     * pembuat / author dari postingan tersebut
     */
    public function destroyPost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        $post->delete();
        $this->postData();
    }

    /**
     * destroyComment() function untuk menghapus data comment yang diinginkan
     * memerlukan parameter id komentar dan user harus login dan merupakan
     * pembuat / author dari komentar tersebut
     */
    public function destroyComment($comment_id)
    {
        $comment = Comment::where('id', $comment_id)->first();
        $comment->delete();
        $this->refreshComment();
    }

    /**
     * private function getHashtags($string) function private yang tidak akan dapat digunakan pada
     * blade namun akan digunakan di livewire php langsung untuk mencari hash dari text yang diisikan
     * misal text pada postingan dan komentar, kemudian function akan mereturn array hashtags
     */
    private function getHashtags($string) { 
        $hashtags = null;
        preg_match_all("/(#\w+)/u", $string, $matches);  
        if ($matches) {
            $hashtags = $matches[0];
        }
        return $hashtags;
    }
}
