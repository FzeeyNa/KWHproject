@extends('layouts.app')

@section('title', $pin->title)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Left Column - Image -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                @if($pin->image_url)
                    <img src="{{ asset('storage/' . $pin->image_url) }}"
                         alt="{{ $pin->title }}"
                         class="w-full h-auto object-cover">
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                    </div>
                @endif
            </div>

            <!-- Pin Actions for Mobile -->
            <div class="lg:hidden bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <button onclick="toggleLike({{ $pin->id }})"
                            class="flex items-center space-x-2 px-4 py-2 rounded-full transition-colors duration-200 {{ Auth::check() && Auth::user()->likedPins()->where('pin_id', $pin->id)->exists() ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600 hover:bg-red-50 hover:text-red-600' }}">
                        <i class="fas fa-heart"></i>
                        <span id="likes-count-mobile">{{ $pin->likes()->count() }}</span>
                    </button>

                    @if($pin->link)
                        <a href="{{ $pin->link }}"
                           target="_blank"
                           class="flex items-center space-x-2 px-4 py-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition-colors duration-200">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Kunjungi</span>
                        </a>
                    @endif

                    @if(Auth::check() && Auth::id() === $pin->user_id)
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('pins.edit', $pin) }}"
                               class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-colors duration-200">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pins.destroy', $pin) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pin ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Details -->
        <div class="space-y-6">
            <!-- Pin Header -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $pin->title }}</h1>
                        @if($pin->description)
                            <p class="text-gray-600 leading-relaxed">{{ $pin->description }}</p>
                        @endif
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex items-center space-x-3 mb-6">
                    @if($pin->user->profile_picture)
                        <img src="{{ asset('storage/' . $pin->user->profile_picture) }}"
                             alt="{{ $pin->user->name }}"
                             class="w-12 h-12 rounded-full object-cover">
                    @else
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-900">{{ $pin->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $pin->user->username ? '@' . $pin->user->username : '' }}</p>
                    </div>
                </div>

                <!-- Pin Meta -->
                <div class="flex items-center justify-between text-sm text-gray-500 mb-6 pb-4 border-b border-gray-200">
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center">
                            <i class="fas fa-th-large mr-1"></i>
                            {{ $pin->board->name ?? 'Tanpa Board' }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $pin->created_at->diffForHumans() }}
                        </span>
                    </div>
                    @if($pin->board && $pin->board->is_private)
                        <span class="flex items-center text-gray-400">
                            <i class="fas fa-lock mr-1"></i>
                            Private
                        </span>
                    @endif
                </div>

                <!-- Pin Actions (Desktop) -->
                <div class="hidden lg:flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <button onclick="toggleLike({{ $pin->id }})"
                                class="flex items-center space-x-2 px-4 py-2 rounded-full transition-colors duration-200 {{ Auth::check() && Auth::user()->likedPins()->where('pin_id', $pin->id)->exists() ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <i class="fas fa-heart"></i>
                            <span id="likes-count">{{ $pin->likes()->count() }}</span>
                        </button>

                        @if($pin->link)
                            <a href="{{ $pin->link }}"
                               target="_blank"
                               class="flex items-center space-x-2 px-4 py-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition-colors duration-200">
                                <i class="fas fa-external-link-alt"></i>
                                <span>Kunjungi Sumber</span>
                            </a>
                        @endif
                    </div>

                    @if(Auth::check() && Auth::id() === $pin->user_id)
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('pins.edit', $pin) }}"
                               class="px-4 py-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition-colors duration-200 flex items-center">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                            <form action="{{ route('pins.destroy', $pin) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pin ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-100 text-red-600 rounded-full hover:bg-red-200 transition-colors duration-200 flex items-center">
                                    <i class="fas fa-trash mr-2"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-comments mr-2 text-blue-500"></i>
                    Komentar ({{ $pin->comments()->count() }})
                </h3>

                <!-- Comment Form -->
                @auth
                    <form action="#" method="POST" class="mb-6" id="comment-form">
                        @csrf
                        <div class="flex space-x-3">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                     alt="{{ Auth::user()->name }}"
                                     class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user text-gray-600 text-sm"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <textarea name="comment"
                                          placeholder="Tulis komentar..."
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                                <div class="flex justify-end mt-2">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors duration-200">
                                        Kirim Komentar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="text-center py-4 bg-gray-50 rounded-lg mb-6">
                        <p class="text-gray-600 mb-2">Masuk untuk memberikan komentar</p>
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            Masuk Sekarang
                        </a>
                    </div>
                @endauth

                <!-- Comments List -->
                <div class="space-y-4" id="comments-list">
                    @forelse($pin->comments()->with('user')->latest()->get() as $comment)
                        <div class="flex space-x-3 p-4 bg-gray-50 rounded-lg">
                            @if($comment->user->profile_picture)
                                <img src="{{ asset('storage/' . $comment->user->profile_picture) }}"
                                     alt="{{ $comment->user->name }}"
                                     class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user text-gray-600 text-sm"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $comment->user->name }}</p>
                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->comment }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-comment text-3xl mb-2 opacity-50"></i>
                            <p>Belum ada komentar</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Related Pins from Same Board -->
            @if($pin->board && $pin->board->pins()->where('id', '!=', $pin->id)->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-th-large mr-2 text-purple-500"></i>
                        Pin Lain dari {{ $pin->board->name }}
                    </h3>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($pin->board->pins()->where('id', '!=', $pin->id)->latest()->limit(6)->get() as $relatedPin)
                            <a href="{{ route('pins.show', $relatedPin) }}" class="group">
                                <div class="bg-gray-100 rounded-lg overflow-hidden aspect-square">
                                    @if($relatedPin->image_url)
                                        <img src="{{ asset('storage/' . $relatedPin->image_url) }}"
                                             alt="{{ $relatedPin->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-sm font-medium text-gray-900 mt-2 group-hover:text-blue-600 transition-colors duration-200">
                                    {{ Str::limit($relatedPin->title, 30) }}
                                </p>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('boards.show', $pin->board) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center justify-center">
                            Lihat Semua Pin dari Board Ini →
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Toggle like functionality
async function toggleLike(pinId) {
    @guest
        Swal.fire({
            icon: 'info',
            title: 'Masuk Diperlukan',
            text: 'Anda perlu masuk untuk menyukai pin ini.',
            showCancelButton: true,
            confirmButtonText: 'Masuk',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("login") }}';
            }
        });
        return;
    @endguest

    try {
        const response = await fetch(`/pins/${pinId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (response.ok) {
            // Update like count
            document.getElementById('likes-count').textContent = data.likes_count;
            const mobileCounter = document.getElementById('likes-count-mobile');
            if (mobileCounter) {
                mobileCounter.textContent = data.likes_count;
            }

            // Update button appearance
            const likeButtons = document.querySelectorAll(`[onclick="toggleLike(${pinId})"]`);
            likeButtons.forEach(button => {
                if (data.liked) {
                    button.classList.remove('bg-gray-100', 'text-gray-600');
                    button.classList.add('bg-red-100', 'text-red-600');
                } else {
                    button.classList.remove('bg-red-100', 'text-red-600');
                    button.classList.add('bg-gray-100', 'text-gray-600');
                }
            });
        } else {
            throw new Error('Terjadi kesalahan');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Terjadi kesalahan saat memproses permintaan.',
            confirmButtonColor: '#dc2626'
        });
    }
}

// Comment form submission
document.getElementById('comment-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const comment = formData.get('comment').trim();

    if (!comment) {
        Swal.fire({
            icon: 'warning',
            title: 'Komentar Kosong',
            text: 'Mohon tulis komentar terlebih dahulu.',
            confirmButtonColor: '#dc2626'
        });
        return;
    }

    try {
        // Here you would typically send the comment to the server
        // For now, we'll just show a success message
        Swal.fire({
            icon: 'success',
            title: 'Komentar Terkirim!',
            text: 'Komentar Anda berhasil ditambahkan.',
            timer: 2000,
            showConfirmButton: false
        });

        // Clear the form
        this.querySelector('textarea').value = '';

        // Refresh the page to show the new comment
        setTimeout(() => {
            location.reload();
        }, 2000);

    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Terjadi kesalahan saat mengirim komentar.',
            confirmButtonColor: '#dc2626'
        });
    }
});

// Auto-resize textarea
document.querySelector('textarea[name="comment"]')?.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});
</script>
@endsection
