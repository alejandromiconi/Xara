@use('App\Constants\Constants')

@php

    //dd($_POST["customer_id"] ?? null);

    $view = $action === Constants::ACTION_VIEW;
    function get_type($column)
    {
        return $column->type ?? "text";
    }


@endphp


<x-app-layout>

    <h2>{{ $title ?? get_name($name) }}</h2>

    <p class="fw-bolder text-uppercase">{{ $action }}</p>

    <x-error-messages />

    <form method="POST" action="{{ get_url() . "/store" }}">

        @csrf

        <x-edit-buttons view="{{ $view }}" />

        @foreach($columns as $column)

            @php($readonly = $view || in_array($column->id, Constants::readOnlyColumns()))
            @php($value = old($column->id, $data[$column->id] ?? $column->initial))
            @php($value = $column->format($value, true))
            @if(in_array($column->id, Constants::timestampColumns()))
                @continue
            @endif
            @php($type = get_type($column))

            <x-text-input :disabled="$readonly" type="{{ $type }}" name="{{ $column->id }}" value="{{ $value }}"
                label="{{ $column->name }}" :options="$column->options" />

        @endforeach

        <input type="hidden" name="_json" value="{{ 
            json_encode([
        "name" => $name,
        "action" => $action,
        "id" => $id,
        //"url" => request()->path()

    ]) }}" />

        <x-edit-buttons view="{{ $view }}" />

    </form>

</x-app-layout>