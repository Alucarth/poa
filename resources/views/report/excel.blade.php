<html>
	<head>
		<link href="{{ asset('css/table.css') }}" rel="stylesheet">
    </head>
    <body>
        <table>

            <thead>
                <tr>
                    <td height="70"> <img src="{{public_path('img/logo_eba.png')}}" width="70" height="70" alt="logo eba"> </td>
                    <td colspan="8" bgcolor="#FF0000" align="center" > EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS </td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="8" bgcolor="#FF0000" align="center" > GERENCIA DE PLANIFICIACION Y DESARROLLO </td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="8" bgcolor="#FF0000" align="center" > REPORTE {{$title}}</td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="8" bgcolor="#FF0000" align="center" > {{$date}}</td>
                </tr>
                <tr>
                    @foreach ($columns as $col)
                        <th  bgcolor="#FF0000" style="color:#ffffff" >{{$col->label}}</th>
                    @endforeach

                    {{-- <th><img src="{{public_path('img/logosedem.png')}}" alt="logo eba"></th> --}}
                </tr>

            </thead>
            <tbody>
                    @foreach ($rows as $row)
                    <tr class="content">
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->meta }}</td>
                        <td>{{ $row->executed }}</td>
                        <td>{{ $row->efficacy }}</td>
                        <td>{{ $row->programacion_acumulada }}</td>
                        <td>{{ $row->ejecucion_acumulada }}</td>
                        <td>{{ $row->porcentaje_pa }}</td>
                        <td>{{ $row->porcentaje_ea }}</td>
                        <td>{{ $row->eficacia_ejecucion_acumulada }}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </body>
    <!-- Horizontal alignment -->
    {{-- <td align="right">Big title</td>

    <!--  Vertical alignment -->
    <td valign="middle">Bold cell</td>

    <!-- Rowspan -->
    <td rowspan="3">Bold cell</td>

    <!-- Colspan -->
    <td colspan="6">Italic cell</td>

    <!-- Width -->
    <td width="100">Cell with width of 100</td>

    <!-- Height -->
    <td height="100">Cell with height of 100</td> --}}

</html>
