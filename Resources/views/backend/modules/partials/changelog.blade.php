<div class="ui relaxed divided list">
    @foreach ($changelog as $version)
    <div class="item">
        <i class="large tag top aligned icon"></i>
        <div class="content">
            <h3 class="ui header"><span class="ui blue text">{{ $version['name'] }}</span>@if($version['date']) - {{ $version['date'] }}@endif</h3>
            <div class="description">
                <div class="ui list">
                    @foreach($version['changes'] as $eventType => $eventData)
                            @include("modules::backend.modules.partials.changelog-events.$eventType", ['data' => $eventData])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>