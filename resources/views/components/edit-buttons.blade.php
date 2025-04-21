@php
    $view = $view ?? false;
    $text = $view ? "Back" : "Cancel";
@endphp

<div class="my-2">

    @if($view)

    @else
        <x-primary-button>Confirm</x-primary-button>
    @endif

    <x-back-button text="{{ $text }}"/>

</div>