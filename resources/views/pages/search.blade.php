@use('App\Constants\Constants')
<x-app-layout>

    @php
        $tables = "table table-sm table-bordered table-hover table-responsive";
    @endphp

    <h2>{{ $title ?? get_name($name) }}</h2>

    <x-error-messages />

    <form method="post" action="{{ get_url() }}">
        @csrf

        <table class="{{ $tables }}" style="margin: 0">
            <thead class="table-light">
                <tr>
                    @foreach($columns as $column)
                        <th class="px-2">{{ $column->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($columns as $column)
                    @php($value = $values[$column->id] ?? "")
                    @php($type = $column->type ?? "text")
                    <td class="px-2">
                        <x-text-input type="{{ $type }}" name="{{ $column->id }}" value="{{ $value }}"
                            :options="$column->options" />
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>

        @php($value = key_exists("include_timestamps", $_POST) ?? false)

        <x-text-input type="checkbox" name="include_timestamps" label="Include Timestamps" value="{{ $value }}" />

        <div class="d-flex gap-2 my-2">
            <x-primary-button class="btn-secondary">Find</x-primary-button>
            <!-- <x-actions name="{{ $name }}" :actions="$actions" part="{{ Constants::PART_BULK }}" id="0" type="bulk" /> -->
            <x-actions class="d-flex align-items-center" name="{{ $name }}" :actions="$actions"
                part="{{ Constants::PART_HEADER }}" id="0" />
        </div>

        <input type="hidden" name="_json" value="{{ 
            json_encode(["name" => $name]) }}" />

    </form>

    <table class="{{ $tables }}">
        <thead class="table-light">
            <tr>
                <th class="text-center">
                    <input class="form-check-input" type="checkbox" name="checkbox_all"
                        onclick="checkAll(this, 'checkbox_')" />
                </th>

                <th>
                </th>

                @foreach($columns as $column)
                    <th class="px-2">{{ $column->name }}</th>
                @endforeach

            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>

                @php($checkbox = "checkbox_" . $row['id'])

                <td class="text-center">
                    <input class="form-check-input" type="checkbox" name="{{ $checkbox }}" />
                </td>

                <td class="text-center">
                    <x-actions name="{{ $name }}" :actions="$actions" part="{{ Constants::PART_DETAIL }}"
                        id="{{ $row['id'] }}" />
                </td>

                @foreach($columns as $column)
                @php($value = $row->{$column->id})
                <td class="text-truncate px-2 {{ $column->is_numeric() || $column->is_datetime() ? "text-end" : "" }}"
                    style="max-width: 150px;">{{ $column->format($value, $name) }}</td>
                @endforeach

            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($data)
        <div class="my-4">{{ $data->links() }}</div>
        <p>Records count {{ $count }} ({{ ceil($count / Constants::PAGINATION) }} pages)</p>
    @else
        Press find to start the query!
    @endif
</x-app-layout>


<script>

    const checkAll = (checkbox, prefix) => {
        const checkboxes = document.querySelectorAll(`input[name^="${prefix}"]`);
        checkboxes.forEach((cb) => {
            cb.checked = checkbox.checked;
        });
    }
</script>