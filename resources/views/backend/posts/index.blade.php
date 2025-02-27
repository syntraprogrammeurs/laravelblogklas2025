@extends('layouts.backend')
@section('title', 'Posts')
@section('cards')
@endsection
@section('charts')
@endsection
@section('content')
    <div class="container-fluid px-4">
{{--        @include('layouts.partials.flash_message')--}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Posts Beheer</h1>
            @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Nieuwe Post</a>
            @endcan
        </div>
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table me-1"></i> Overzicht van Posts</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Afbeelding</th>
                        <th>Titel</th>
                        <th>Auteur</th>
                        <th>Gepubliceerd</th>
                        <th>Categorieën</th>
                        <th>Aangemaakt</th>
                        <th>Bewerkt</th>
                        <th>Acties</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Afbeelding</th>
                        <th>Titel</th>
                        <th>Auteur</th>
                        <th>Gepubliceerd</th>
                        <th>Categorieën</th>
                        <th>Aangemaakt</th>
                        <th>Bewerkt</th>
                        <th>Acties</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>
                                @if($post->photo && file_exists(public_path('assets/img/' . $post->photo->path)))
                                    <img src="{{ asset('assets/img/' . $post->photo->path) }}"
                                         alt="{{ $post->photo->alternate_text ?? 'Post afbeelding' }}"
                                         class="img-fluid rounded object-fit-cover"
                                         style="width: 60px; height: 60px;">
                                @else
                                    <img src="https://placehold.co/60"
                                         alt="Geen afbeelding"
                                         class="img-fluid rounded object-fit-cover"
                                         style="width: 60px; height: 60px;">
                                @endif
                            </td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->author->name }}</td>
                            <td>
                                    <span class="badge {{ $post->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $post->is_published ? 'Ja' : 'Nee' }}
                                    </span>
                            </td>
                            <td>
                                @foreach($post->categories as $category)
                                    <span class="badge bg-info">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $post->created_at->diffForHumans() }}</td>
                            <td>{{ $post->updated_at->diffForHumans() }}</td>
                            <td class="align-middle">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('posts.show', $post) }}"
                                       class="btn btn-sm btn-primary"
                                       title="Bekijk Post">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('update', $post)
                                        <a href="{{ route('posts.edit', $post) }}"
                                           class="btn btn-sm btn-info"
                                           title="Bewerk Post">
                                            <i class="fas fa-edit text-white"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $post)
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Verwijder Post"
                                                    onclick="return confirm('Weet je zeker dat je deze post wilt verwijderen?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                                <!-- Show (View) button -->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$posts->links()}}
            </div>
        </div>
    </div>
@endsection
