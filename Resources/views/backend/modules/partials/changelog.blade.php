<div class="ui relaxed divided list">
    @foreach ($changelog['versions'] as $version => $info)
    <div class="item">
        <i class="large tag top aligned icon"></i>
        <div class="content">
            <a href="{{ $changelog['url'].'/releases/tag/'.$version }}" target="_blank" class="header">{{ $version }}</a>
            <div class="description">
                <div class="ui list">
                    @foreach($info as $eventType => $eventData)
                            @include("modules::backend.modules.partials.changelog-events.$eventType", ['data' => $eventData])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>