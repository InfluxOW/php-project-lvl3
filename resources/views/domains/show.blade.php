@extends('layouts.app')

@section('content')
<div class="container-fullwidth">
    <table class="table table-bordered text-center">
        <thead class="thead-light">
            <tr class="d-flex">
                <th class="col-md-1">#</th>
                <th class="col-md-3">URL</th>
                <th class="col-md-1">Response Code</th>
                <th class="col-md-1">Content Length</th>
                <th class="col-md-1">Main header</th>
                <th class="col-md-3">Description</th>
                <th class="col-md-1">Keywords</th>
                <th class="col-md-1">Creation Date</th>
            </tr>
        </thead>
        <tbody class="section section-step">
            <tr class=" {{ getTableStyle($domain->processingState()->getState(), 'show')  }}">
            <td class="col-md-1">{{ $domain->id }}</td>
            <td class="col-md-3"><a href="{{ $domain->name }}" class="opacity-70">{{ $domain->name }}</a></td>
            <td class="col-md-1">{{ $domain->response_code }}</td>
            <td class="col-md-1">{{ $domain->content_length ?? '---' }}</td>
            <td class="col-md-1">{{ strlen($domain->h1) > 2 ? $domain->h1 : '---' }}</td>
            <td class="col-md-3">{{ $domain->description ?? '---' }}</td>
            <td class="col-md-1">{{ $domain->keywords ?? '---' }}</td>
            <td class="col-md-1">{{ $domain->created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>
{{-- <script type="text/javascript">
    var state = "{{ $domain->state }}";
    if (state === 'waiting') {
        setTimeout(function () { document.location.reload(true); }, 4000);
    }
</script> --}}

@endsection
