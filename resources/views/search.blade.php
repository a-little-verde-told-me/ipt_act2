@extends('headerfooter')

@section('title', 'Search | FLEUR')

@section('content')
<div class="search-page">
    <h1>Search Engine</h1>

    <form class="search-form" action="{{ route('search') }}" method="get">
        <div class="search-bar">
            <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" name="q" placeholder="Search the site..." value="{{ $query }}" required>
        </div>
        <button class="submit-btn" type="submit">Search</button>
    </form>

    <div class="search-meta">
        <p>Query: <strong>{{ $query !== '' ? $query : '—' }}</strong></p>
        <p>Results: <strong>{{ $total }}</strong></p>
    </div>

    <div class="serp">
        @if($total === 0)
            <p class="empty-state">No results found.</p>
        @else
            @foreach($results as $result)
                <div class="serp-item">
                    <a href="{{ $result['url'] }}" class="serp-title">{{ $result['title'] }}</a>
                    <p class="serp-blurb">{{ $result['blurb'] }}</p>
                    <p class="serp-url">{{ $result['url'] }}</p>
                </div>
            @endforeach
        @endif
    </div>

    @if($totalPages > 1)
        <div class="pagination">
            @for($i = 1; $i <= $totalPages; $i++)
                <a class="page-link {{ $i === $page ? 'active' : '' }}" href="{{ route('search', ['q' => $query, 'page' => $i]) }}">{{ $i }}</a>
            @endfor
        </div>
    @endif

    <div class="search-db">
        <h2>Search Database</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Blurb</th>
                    <th>URL</th>
                    <th>Keyword</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item['id'] }}</td>
                        <td>{{ $item['title'] }}</td>
                        <td>{{ $item['blurb'] }}</td>
                        <td>{{ $item['url'] }}</td>
                        <td>{{ $item['keywords'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
