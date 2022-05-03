<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;

class CommentsSection extends Component
{
    public Post $post;
    public $comment;

    public $successMessage;

    protected $rules = [
        'comment' => 'required|min:4',
        'post' => 'required',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function postComment()
    {
        $this->validate();

        sleep(1);

        Comment::create([
            'post_id' => $this->post->id,
            'username' => 'Guest',
            'content' => $this->comment,
        ]);

        $this->comment = '';

        //force livewire to render and show the new post due to state change
        $this->post = Post::find($this->post->id);

        //You can also use $this->post->refresh() to re-hydrate the Post model using fresh data from the database.

        //session()->flash('success_message','Comment was posted');
        $this->successMessage =  'Comment was posted!';
    }

    public function render()
    {
        return view('livewire.comments-section');
    }
}
