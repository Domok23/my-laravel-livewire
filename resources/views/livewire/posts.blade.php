<div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3>
                            Posts CRUD
                            <button class="btn btn-primary float-right" wire:click="create">
                                Create New Post
                            </button>
                        </h3>
                    </div>
                    <div class="card-body">
                        <input type="text" wire:model.debounce.300ms="search" placeholder="Search posts..." class="form-control mb-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th width="150px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $index => $post)
                                    <tr>
                                        <td>{{ $posts->firstItem() + $index }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->description }}</td>
                                        <td>{{ $post->status }}</td>  <!-- Menampilkan status -->
                                        <td>
                                            <button wire:click="edit({{ $post->id }})"
                                                class="btn btn-primary btn-sm">
                                                Edit
                                            </button>
                                            <button wire:click="delete({{ $post->id }})"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No posts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $posts->links() }}
                            <div wire:loading class="mb-2">Processing...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $post_id ? 'Edit Post' : 'Create Post' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div wire:loading class="mb-2">
                        Processing...
                    </div>

                    <form wire:loading.remove>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" wire:model.defer="title" class="form-control">
                            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Description</label>
                            <textarea wire:model.defer="description" class="form-control"></textarea>
                            @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <!-- Dropdown untuk status -->
                        <div class="form-group">
                            <label>Status</label>
                            <select wire:model="status" class="form-control">
                                <option value="">Select Status</option>
                                @foreach ($statuses as $statusOption)
                                    <option value="{{ $statusOption }}">{{ ucfirst($statusOption) }}</option>
                                @endforeach
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="store">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
