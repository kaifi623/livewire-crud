<div class="p-6 text-center">
    <h1 class="mt-5 text-center text-4xl mb-6">Posts Detail</h1>

    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <!-- Search Input -->
        <div class="xl:w-96 w-full">
            <div class="relative">
                <input type="text" wire:model.live="search" placeholder="Search by title or description"
                    class="w-full pl-10 pr-4 py-2 rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M17 17A7.5 7.5 0 103.5 3.5 7.5 7.5 0 0017 17z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Create Button -->
        <div>
            <button wire:model='showForm' wire:click='postForm'
                class="cursor-pointer px-4 py-2 rounded-md text-white bg-green-500 hover:bg-green-700">
                Create a New Post
            </button>
        </div>
    </div>



    <div class="overflow-hidden  rounded-4xl shadow-md">
    <table class="w-full table-auto border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">S-NO</th>
                <th class="border px-4 py-2">TITLE</th>
                <th class="border px-4 py-2">DESCRIPTION</th>
                <th class="border px-4 py-2">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @if ($posts)
                @foreach($posts as $post)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2 text-center">{{ $post->title }}</td>
                    <td class="border px-4 py-2 text-center">{{ $post->description }}</td>
                    <td class="border px-4 py-2 text-center">
                        <button wire:click="edit({{ $post->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 cursor-pointer" >
                            Edit
                        </button>
                        <button wire:click="delete({{ $post->id }})"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 cursor-pointer ml-2">
                            Delete
                        </button>
                        <button wire:click="view({{ $post->id }})"
                            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 cursor-pointer ml-2">
                            View
                        </button>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">No data found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


    {{-- pagination --}}

    <div class="mt-4 [&_button]:cursor-pointer">
        {{ $posts->links() }}
    </div>


    {{-- Modal for Edit --}}
    @if($showModal)
    <div class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-1/3 shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Edit Post</h2>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Title</label>
                <input type="text" wire:model="title"
                    class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-300" />
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Description</label>
                <textarea wire:model="description"
                    class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-300"></textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <button wire:click="update"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 cursor-pointer">Update</button>
                <button wire:click="cancel"
                    class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 cursor-pointer">Cancel</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal for View --}}
    @if($viewModal && $viewingPost)
    <div class="fixed inset-0 bg-black/50 bg-opacity-30 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-1/3 shadow-lg">
            <h2 class="text-xl font-semibold mb-4">View Post</h2>

            <div class="mb-4">
                <h1 class="block mb-1 font-medium">Title</h1>
                <div class="border border-indigo-300 rounded-xl p-6 bg-indigo-50 shadow-md">
                    <h3 class="text-xl font-semibold text-indigo-700">{{ $viewingPost->title }}</h3>
                </div>
            </div>

            <div class="mb-4">
                <h1 class="block mb-1 font-medium">Description</h1>
                <div class="border border-indigo-300 rounded-xl p-6 bg-indigo-50 shadow-md">
                    <h3 class="text-xl font-semibold text-indigo-700">{{ $viewingPost->description }}</h3>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <button wire:click="close"
                    class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 cursor-pointer">Close</button>

            </div>
        </div>
    </div>
    @endif

    {{-- modal for delete --}}
    @if($confirmingDelete)
    <!-- Overlay (semi-transparent black) -->
    <div class="fixed inset-0 z-50 bg-black/50 "></div>

    <!-- Modal (centered, above overlay) -->
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Confirm Delete</h2>
            <p class="mb-6">Are you sure you want to delete "{{ $deletePost->title}}" post?</p>
            <div class="flex justify-end gap-3">
                <button wire:click="cancelDelete" class="px-4 py-2 border rounded-md hover:bg-gray-50 cursor-pointer">
                    Cancel
                </button>
                <button wire:click="confirmDelete"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 cursor-pointer">
                    Delete
                </button>
            </div>
        </div>
    </div>
    @endif


    {{-- modal for new post --}}

   @if ($showForm)
    <div class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-1/3 shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Create Post</h2>

            <form wire:submit.prevent="store">
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Title</label>
                    <input type="text" wire:model="title"
                        class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required />
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Description</label>
                    <textarea wire:model="description"
                        class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 cursor-pointer">
                        Create
                    </button>
                </div>
            </form>

            <div class="flex justify-end mt-2">
                <button wire:click="closeForm"
                    class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 cursor-pointer">
                    Cancel
                </button>
            </div>
        </div>
    </div>
@endif


</div>
