@extends('layouts.master')

@section('title')
    {{ trans('modules::modules.title.modules') }}
@endsection

@section('content')

    <h2 class="ui dividing header">@lang('modules::modules.types.core modules')</h2>

    <table class="ui selectable celled definition table">
        <thead>
        <tr>
        <tr>
            <th></th>
            <th class="four wide">{{ trans('modules::modules.table.name') }}</th>
            <th class="eight wide">{{ trans('modules::modules.table.description') }}</th>
            <th class="three wide">{{ trans('modules::modules.table.version') }}</th>
        </tr>
        </tr>
        </thead>
        <tbody>
        @foreach ($coreModules as $module)
            <tr>
                <td class="collapsing">
                        <a class="ui blue ribbon label">@lang('modules::modules.types.core')</a>
                </td>
                <td>
                    <a href="{{ route('backend::modules.modules.show', [$module->getLowerName()]) }}">
                        {{ $module->name }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('backend::modules.modules.show', [$module->getLowerName()]) }}">
                        {{ $module->description }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('backend::modules.modules.show', [$module->getLowerName()]) }}">
                        {{ str_replace('v', '', $module->version) }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="ui hidden divider"></div>
    <h2 class="ui dividing header">@lang('modules::modules.types.third party modules')</h2>

    <table class="ui selectable celled table">
        <thead>
        <tr>
        <tr>
            <th class="four wide">{{ trans('modules::modules.table.name') }}</th>
            <th class="five wide">{{ trans('modules::modules.table.description') }}</th>
            <th class="four wide">{{ trans('modules::modules.table.vendor') }}</th>
            <th class="two wide">{{ trans('modules::modules.table.version') }}</th>
            <th class="one wide">{{ trans('modules::modules.table.enabled') }}</th>
        </tr>
        </tr>
        </thead>
        <tbody>
        @foreach ($thirdPartyModules as $module)
            <tr>
                <td>
                    <a href="{{ route('backend::modules.modules.show', [$module->getLowerName()]) }}">
                        {{ $module->name }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('backend::modules.modules.show', [$module->getLowerName()]) }}">
                        {{ $module->description }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('backend::modules.modules.show', [$module->getLowerName()]) }}">
                        {{ $module->vendor }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('backend::modules.modules.show', [$module->getLowerName()]) }}">
                        {{ str_replace('v', '', $module->version) }}
                    </a>
                </td>
                <td class="center aligned">
                    @if($module->enabled())
                        <i class="large green checkmark icon"></i>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@section('javascript')
@endsection
