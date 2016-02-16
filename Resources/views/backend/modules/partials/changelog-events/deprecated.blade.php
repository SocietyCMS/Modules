<ol class="ui list">
    <li value=""><div class="header">@lang('modules::changelog.events.deprecated')</div>
        <ol>
            @foreach ($data as $dataLine)
                <li value="-">{!! $dataLine !!}</li>
            @endforeach
        </ol>
    </li>
</ol>