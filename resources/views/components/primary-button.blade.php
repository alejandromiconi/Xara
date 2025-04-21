<button {{ $attributes->merge(['type' => 'submit', 
    'class' => 'btn btn-primary btn-large']) }}>
    {{ $slot }}
</button>
