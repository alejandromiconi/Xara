@use('App\Constants\Constants')

@props([
'disabled' => false,
])

@php

    $name = $attributes["name"];
    $type = $attributes["type"] ?? "";
    $options = $attributes["options"] ?? [];
    unset($attributes["options"]);

@endphp

    @if(Constants::hasLabel($type))
        @if($attributes["label"])
            <label class="block font-medium text-sm text-gray-700" for="{{ $attributes["name"] }}"
            >{{ $attributes["label"] }}</label>
        @endif
    @endif

    <div class="mb-3 {{ $attributes["div-class"] ?? "" }}" style="{{ $attributes["div-style"] ?? "" }}">

    @switch($type)


        @case(Constants::FT_HIDDEN)
            <input type="hidden" name="{{ $name }}" value="{{ $attributes["value"] }}" />
            @break

        @case(Constants::FT_SELECT)

            @php
                if($attributes["required"]) ;
                else {
                    array_unshift($options, [ "value" => "", "label" => "" ]);
                }
            @endphp

            <select @disabled($disabled)
                {{ $attributes->merge([
                    'id' => $name,
                    'class' => 'form-select']) }}>

                @foreach($options as $option)
                    <option value="{{ $option["value"] }}" 
                        {{ ($option["value"] == $attributes["value"]) ? "selected" : "" }}>
                        {{ $option["label"] }}
                    </option>
                    @endforeach


            </select>
            @break


        @case(Constants::FT_TEXT)

            <textarea @disabled($disabled)
                {{ $attributes->merge([
                    'id' => $name,
                    'class' => 'form-control']) }}>{{ $attributes["value"] }}</textarea>


            @break

        @case(Constants::FT_CHECKBOX)

            @php
                $checked = ($attributes["value"] ?? false) ? "checked" : "";
                unset($attributes["value"]);
            @endphp

            <input @disabled($disabled)
            {{ $attributes->merge([
                    'id' => $name,
                    'class' => 'form-check-input']) }}
                {{ $checked }} />
            @if($attributes["label"])
                <label class="form-check-label" for="{{ $attributes["name"] }}"> {{ $attributes["label"] }} </label>
            @endif

            @break

        @case(Constants::FT_SEARCH)

            <input @disabled($disabled) type="text" id="{{ "search_$name" }}"
                class="form-control search" />

            <input type="hidden" name="{{ $name }}" id="{{ $name }}" value="{{ $attributes["value"] }}" />

            <div class="mt-1" id="searchOverlay_{{ $name }}" ></div>

            @break

        @default

            <input @disabled($disabled)
                {{ $attributes->merge([
                    'id' => $name,
                    'class' => 'form-control' ]) }} />
            @break

    @endswitch

{{ $slot }}

</div>