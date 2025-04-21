@props(["actions", "name", "part", "id", "type" => ""])

@php
    $list = array_filter($actions, fn($action) => $action["part"] == $part);
    reset($list);

    
    $options = array_map(fn($action) => 
        [ "value" => $action["id"] , "label" => $action["name"]], $list);

@endphp

@once
    @php
        function get_action($action, $name, $id, $type = 0)
        {
            $title = $slot = $action["name"];

            $params = ["name" => $name];
            
            $route = get_url() . "/" . $action["id"];

            if ($action["byid"]) {
                $params["action"] = $action["id"];
                $params["id"] = $id;

                $route .= "/$id";
            }

            //$route = route($action["route"], $params);


            $class = "";
            switch ($type) {

                case 0: // Button
                    $class = "btn btn-secondary btn-large";
                    break;

                case 1: // Dropdown item
                    $class = "dropdown-item";
                    break;
            }

            if (isset($action["submit"])) {
                return "<button type='submit'
                            class='$class action-btn' data-action='$route'>$slot</button>";
            } else {
                return "<a class='$class' title='$title' 
                            href='$route' name=" . $action["id"] . ">$slot</a>";
            }
        }

    @endphp
@endonce

@if (count($list) != 0)

    @if ($type == "bulk")
        <x-text-input class="d-inline" style="width: auto; min-width: 20rem;" 
            type="select" name="bulk" :options="$options" class="btn-secondary" />

    @else

        <a class="text-muted {{ $attributes["class"] }}" data-bs-toggle="dropdown" aria-expanded="false" role="button">
            <i class="bi bi-three-dots-vertical"></i>
        </a>

        <ul class="dropdown-menu" style="">

            @foreach ($list as $action)

                @if (!array_key_exists("id", $action))
                    <hr class="dropdown-divider">

                @else

                    <li>
                        {!! get_action($action, $name, $id, 1) !!}
                    </li>
                @endif

            @endforeach

        </ul>
    
    @endif

    {{ $slot }}

@endif