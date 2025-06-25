<?php

namespace App\Livewire;

use App\Models\Post;
use Laravel\Pail\ValueObjects\Origin\Console;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithPagination;

class FetchPosts extends Component
{
     use WithPagination;

   public $postId;
   public $title;                 // for editing
   public $description;           // for editing
   public $post_id;
   public $deleteId;
   public $deletePost;


   public $search='';



   public $viewingPost;

   public $showModal=false;
   public $viewModal=false;
   public $showForm=false;
   public $updateMode=false;
   public $confirmingDelete = false;



 public function delete($id)
    {
        $this->deleteId = $id;
        $this->deletePost= Post::find($id);
        $this->confirmingDelete = true;


    }

   public function cancelDelete()
{
    $this->confirmingDelete = false;
    $this->deleteId = null;
    $this->deletePost = null;
    $this->cancel();
}

public function confirmDelete()
{
    Post::find($this->deleteId)?->delete();
    $this->cancelDelete();
    $this->resetPage();


}


    public function postForm(){
        $this->showForm=true;
    }

    public function closeForm(){
       // $this->resetFields();
       $this->cancel();
        $this->showForm=false;
    }

     public function store()
    {
        Post::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);
         $this->resetFields();
        $this->resetPage();
        $this->showForm=false;
    }
     public function resetFields()
    {
        $this->title = '';
        $this->description = '';
        $this->post_id = null;
        $this->updateMode = false;
    }


    public function edit($id){
        $post = Post::findOrFail($id);
        $this->postId = $id;
        $this->title = $post->title;                   // this line display the actuall data in the input field
        $this->description = $post->description;       // same as above
        $this->showModal = true;
    }

    public function cancel(){
        $this->reset(['title','post_id','description','showModal']);
    }

    public function update(){
        $post = Post::findOrFail($this->postId);
        $post->title = $this->title;
        $post->description = $this->description;
        $post->save();

        $this->showModal = false;

    }

    public function view($id){
         $this->viewingPost = Post::findOrFail($id);
        $this->viewModal=true;
    }

    public function close(){
        $this->viewModal=false;
    }



    public function render()
    {
          $searchTerm = '%' . $this->search . '%';

         return view('livewire.fetch-posts', [
            'posts' => Post::where('title', 'like', $searchTerm)
                           ->orWhere('description', 'like', $searchTerm)
                           ->orderBy('id', 'desc')
                           ->paginate(9),
         ]);
    }
    public function updatingSearch()
{
    $this->resetPage();
}

}
