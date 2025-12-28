<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-primary-500 to-secondary-500 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-6">
            <h2 class="font-bold text-2xl text-white">
                {{ __('My Files') }}
            </h2>
            <p class="text-primary-100 text-sm mt-1">Upload and manage your files</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Upload Section -->
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 mb-6">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Upload File</h3>
                    
                    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Choose File
                            </label>
                            <input 
                                type="file" 
                                name="file" 
                                id="file"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 transition duration-200"
                                required
                            />
                            @error('file')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button 
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-lg hover:from-primary-600 hover:to-secondary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                        >
                            Upload File
                        </button>
                    </form>
                </div>
            </div>

            <!-- Files List -->
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Your Files</h3>
                    
                    @if($files->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No files uploaded yet.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($files as $file)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-200">
                                    <div class="flex items-center space-x-4 flex-1 min-w-0">
                                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                                {{ $file->original_name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $file->formatted_size }} • {{ $file->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2 ml-4">
                                        <a 
                                            href="{{ route('files.download', $file) }}"
                                            class="px-3 py-2 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition duration-200"
                                        >
                                            Download
                                        </a>
                                        
                                        <form action="{{ route('files.destroy', $file) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit"
                                                class="px-3 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition duration-200"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>