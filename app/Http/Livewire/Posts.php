<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $title, $description, $post_id, $status; // Tambahkan status
    public $search = '';
    public $isOpen = 0;

    // Daftar status yang tersedia
    public $statuses = ['active', 'archive', 'pending', 'gaskan'];

    // Tambahkan ini untuk reset pagination saat pencarian
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = Post::where('title', 'like', "%{$this->search}%")
        ->orWhere('description', 'like', "%{$this->search}%")
        ->latest()
            ->paginate(5);

        return view('livewire.posts', compact('posts'));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->dispatchBrowserEvent('hide-form');
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->post_id = '';
        $this->status = '';  // Reset status
    }

    private function trimInputs()
    {
        $this->title = preg_replace('/\s+/', ' ', trim($this->title));
        $this->description = preg_replace('/\s+/', ' ', trim($this->description));
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:active,archive,pending,gaskan', // Validasi status
        ]);

        Post::updateOrCreate(['id' => $this->post_id], [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status, // Simpan status
        ]);

        session()->flash(
            'message',
            $this->post_id ? 'Post Updated Successfully.' : 'Post Created Successfully.'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->description = $post->description;
        $this->status = $post->status;  // Ambil status untuk form edit

        $this->openModal();
    }

    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }
}