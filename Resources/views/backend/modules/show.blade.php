@extends('layouts.master')

@section('title')
    @lang('modules::modules.title.module')
@endsection
@section('subTitle')
    {{ $module->name }}
@endsection

@section('content')


    <div class="ui grid">
        <div class="eight wide column">
            <div class="ui segment">

                <h1 class="ui header">
                    <i class="settings icon"></i>
                    <div class="content">
                        {{ ucfirst($module->getName()) }}
                        <div class="sub header">{{ $module->version }}</div>
                    </div>
                </h1>
                <div class="ui basic segment">
                    {{$module->getDescription()}}
                </div>
            </div>
        </div>
        <div class="eight wide column">
            <table class="ui definition table">
                <tbody>
                    <tr>
                        <td class="three wide">{{ trans('modules::modules.table.name') }}</td>
                        <td>{{$module->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('modules::modules.table.vendor') }}</td>
                        <td>{{$module->vendor}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('modules::modules.table.version') }}</td>
                        <td>{{$module->version}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('modules::modules.table.keywords') }}</td>
                        <td>
                            @foreach($module->keywords as $keyword)
                                <span class="ui tiny tag label">{{$keyword}}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>

            @unless($module->isCore)
                <table class="ui definition table">
                    <tbody>
                        <tr>
                            <td class="three wide">{{ trans('modules::modules.table.enabled') }}</td>
                            <td>
                                <div class="ui fitted toggle checkbox" id="moduleEnabledCheckbox">
                                    <input type="checkbox" @if($module->enabled())checked="checked"@endif>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endunless
        </div>
    </div>


    @if (!empty($changelog) && count($changelog['versions']))
        <div class="ui hidden divider"></div>
        <h2 class="ui dividing header">@lang('modules::changelog.changelog')</h2>
        <div class="ui segment">
            @include('modules::backend.modules.partials.changelog')
        </div>
    @endif

@endsection

@section('javascript')

    <script>
        $('#moduleEnabledCheckbox')
                .checkbox({
                    beforeChecked: function () {
                        Vue.http.post("{{ route('backend::modules.modules.enable', $module->getName())}}", {_token: "{{csrf_token()}}"}, function (data, status, request) {
                            return true;
                        }).error(function (data, status, request) {
                            return false;
                            console.log(data)
                        });
                    },
                    beforeUnchecked: function () {
                        Vue.http.post("{{ route('backend::modules.modules.disable', $module->getName())}}", {_token: "{{csrf_token()}}"}, function (data, status, request) {
                            return true;
                        }).error(function (data, status, request) {
                            return false;
                            console.log(data)
                        });
                    }
                });

    </script>

@endsection
