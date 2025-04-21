<x-app-layout>

    <h2>{{ get_name($name) }}</h2>

    <x-error-messages />

    <form method="POST" action="{{ route("crud.upload.file", ['name' => $name]) }}" 
        enctype="multipart/form-data">
        @csrf

        <x-text-input type="file" name="file" required />
        <x-text-input type="checkbox" name="ignore_id" label="Ignore Id"
            value="{{ old('ignore_id', false) }}" /> 

        <x-edit-buttons />

        <input type="hidden" name="_json" value="{{ 
            json_encode(["name" => $name ]) }}" />

    </form>


</x-app-layout>