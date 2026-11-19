{{-- Environment details table. Expects $server, $packages and $extensions from App\Support\EnvironmentInfo. --}}
<table class="table table-sm table-striped mb-2" style="font-size: 0.85rem;">
    <tbody>
        @foreach ($server as $label => $value)
            <tr><th style="width: 40%;">{{ $label }}</th><td>{{ $value }}</td></tr>
        @endforeach
        @foreach ($packages as $package => $version)
            <tr><th><code>{{ $package }}</code></th><td>{{ $version }}</td></tr>
        @endforeach
    </tbody>
</table>
<details>
    <summary style="font-size: 0.85rem;">PHP extensions</summary>
    <p style="font-size: 0.8rem;">{{ $extensions }}</p>
</details>
