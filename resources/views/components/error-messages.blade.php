@php

    const MAX_LENGTH = 500;

    function get_message($message) {

        if (strlen($message) > MAX_LENGTH) {
            $message = substr($message, 0, MAX_LENGTH) . "...";
        }

        return $message; 
    }

@endphp


@if(session('success'))
    <div class="alert alert-success">
        {{ get_message(session('success')) }}
    </div>

@elseif(session('error'))
    <div class="alert alert-danger">
        {{ get_message(session('error')) }}
    </div>

@endif

@php($messages = get_error_messages($errors))
    
@if($messages)
    <div class="alert alert-danger">
        <ul>
            @foreach($messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif