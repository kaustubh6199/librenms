@isset($title)
    <div class="tw-border-b tw-font-semibold">
        {{ $title }}
    </div>
@endisset
<div class="tw-flex flex-row tw-flex-wrap" style="width: {{ $rowWidth }}px;">
    @foreach($graphs as $graph)
        <x-graph :type="$type" :loading="$loading" :port="$port" :device="$device" :vars="$graph"></x-graph>
    @endforeach
</div>
