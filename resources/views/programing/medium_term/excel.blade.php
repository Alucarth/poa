<html>
	<head>
		<link href="{{ asset('css/table.css') }}" rel="stylesheet">
	</head>
	<tr class="logo">
		<td colspan="8"></td>
		<td height="50"  colspan="2"> <img src="{{public_path('img/logosedem.png')}}" width="50" height="50" alt="logo eba"> </td>
	</tr>
	<tr class="logo"> 
		<td colspan="8"></td>
		<td colspan="2"> MDP y EP </td>
	</tr>
	<thead>
		<tr>
			<th colspan="4" style="color:#FFFFFF" >Estructura del PDES</th>
			<th rowspan="2" style="color:#FFFFFF">Accion Mediano Plazo del PEE</th>
			<th rowspan="3" style="color:#FFFFFF" width="30">Resultado Promedio</th>
			<th rowspan="3" style="color:#FFFFFF" width="12">Linea base</th>
			<th rowspan="3" style="color:#FFFFFF" width="50"> Indicador de Resultado Intermedio</th>
			<th rowspan="3" style="color:#FFFFFF" width="20">Alcance de Meta</th>
			<th rowspan="3" style="color:#FFFFFF" width="10">Ejecutado</th>
			<th rowspan="3" style="color:#FFFFFF" width="10">Eficacia</th>
			{{-- <th><img src="{{public_path('img/logosedem.png')}}" alt="logo eba"></th> --}}
		</tr>
		<tr>
			<th colspan="4" style="color:#FFFFFF" >COD PDES</th>
		</tr>
		<tr>
			<th width="5" style="color:#FFFFFF">P</th>
			<th width="5" style="color:#FFFFFF">M</th>
			<th width="5" style="color:#FFFFFF">R</th>
			<th width="5" style="color:#FFFFFF">A</th>
			<th width="30" style="color:#FFFFFF">Denominacion</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($amps as $amp)
		<tr class="content">
			<td>{{ $amp->pilar }}</td>
			<td>{{ $amp->meta }}</td>
			<td>{{ $amp->resultado }}</td>
			<td>{{ $amp->accion }}</td>
			<td>{{ $amp->descripcion}}</td>
			<td>{{ $amp->resultado_intermedio}}</td>
			<td>{{ $amp->linea_base}}</td>
			<td>{{ $amp->indicador_resultado_intermedio}}</td>
			<td>{{ $amp->alcance_meta}}</td>
			<td>{{ $amp->ejecutado}}</td>
			<td>{{ $amp->eficacia.'%'}}</td>
		</tr>
		@endforeach
	</tbody>
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