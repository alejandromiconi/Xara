@php($url = get_url())

@if (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == $url) 
    <x-link-button href="javascript:history.back()">Back</x-link-button>
    
@else
    <x-link-button href="{{ $url }}">{{ $text ?? "Back" }}</x-link-button>

@endif
