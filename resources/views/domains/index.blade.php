@extends('layouts.app')

@section('content')
<div class="container-fullwidth">
    <table class="table table-bordered text-center">
        <thead class="thead-light">
            <tr class="d-flex">
                <th class="col-md-1">#</th>
                <th class="col-md-6">URL</th>
                <th class="col-md-1">Response Code</th>
                <th class="col-md-2">Content Length</th>
                <th class="col-md-2">Creation Date</th>
            </tr>
        </thead>
        <tbody class="section section-step">
            @foreach ($domains as $domain)
                @if ($domain->getState() === 'failed')
                <tr class="table-danger d-flex">
                @else
                <tr class="table-success d-flex">
                @endif
                <td class="col-md-1">{{ $domain->id }}</td>
                <td class="col-md-6"><a href="{{ route('domains.show', compact('domain')) }}" style="color: #0000CC; opacity: 0.5">{{ $domain->name }}</a></td>
                <td class="col-md-1">{{ $domain->response_code }}</td>
                <td class="col-md-2">{{ $domain->content_length ?? '---' }}</td>
                <td class="col-md-2">{{ $domain->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

  {!! $domains->render() !!}
@endsection
