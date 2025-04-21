@props(['context', 'name'])

@use('App\Models\Field')

<!Transaction html>
<html lang="{{ str_replace('_', '-', auth()->user()->locale ?? app()->getLocale()) }}">

<head>
    {{-- 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link href="{{ asset('css/xara.css') }}" rel="stylesheet">
 --}}

    <title>{{ $name ?? 'Xara' }}</title>

    <style>
        @page {
            margin-left: 1cm;
            margin-right: 1cm;
        }

        .content {
            font-family: Arial, sans-serif;
            font-size: 9px;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3cm;
            margin-bottom: 1cm;
        }

        table {
            width: 100%;
        }

        table.data {
            margin: 10px, 0;
            border-spacing: 0;
            border-collapse: collapse;
        }

        table.data th {
            background-color: lightgray;
            margin: 0;
            border-spacing: 0;
            padding-right: 5px;
        }

        table.right {
            position: relative; 
            left: 50%; 
            width: 50%;
        }

        .borders {
            border-top: 1px solid black; 
            border-bottom: 1px solid black; 
        }
        
        tr.totals {
            background-color: lightgray;
            font-weight: bold;
        }

        table.header {
            border-bottom: 1px solid black;
        }

        td {
            padding-right: 5px;
        }

        .x-title {
            font-size: larger;
            background-color: lightgray;
            font-weight: bold;
        }

        .text-right {
            text-align: right !important;
        }

        .text-left {
            text-align: left !important;
        }

        .page-break {
            page-break-before: always;
        }

        .page-number:before {
            content: "{{ __("Page") }} " counter(page);
        }

        #header {
            position: fixed;
            left: 0px;
            top: 0px;
            /*-180px;*/
            right: 0px;
            /*height: 150px;*/
        }

        #footer {
            position: fixed;
            left: 0px;
            bottom: -140px;
            /*-180px;*/
            right: 0px;
            height: 150px;
        }

        #footer .page:after {
            content: counter(page, upper-roman);
        }
    </style>

</head>

<body>

    @php($context = $context ?? getContext())

    <div id="header">
        <table>
            <tr>
                <td style="width:50%;">
                    <img class="w-48 mt-6" src="{{ public_path('storage/' . $context->logo) }}">
                </td>
                <td style="line-height: 0;">
                    <h3>{{ $context->name }}</h3>
                    <h4>{{ $context->slogan }}</h4>
                </td>
            </tr>
        </table>

        <hr>
    </div>

    <div id="footer" class="content">

        <table>
            <tr>
                <td style="width:50%;">
                    {!! getLastVersion() !!}
                </td>
                <td class="text-right page-number">
                    {{ __("Printed by") }} {{ $context->user_name }}<br>
                    {{ $context->getLocalDate(true) }}
                </td>
            </tr>
        </table>

    </div>

    <div class="content">
        {{ $slot }}
    </div>

</body>

</html>
