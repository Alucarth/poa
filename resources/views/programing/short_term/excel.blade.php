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
			<th rowspan="2" style="color:#FFFFFF">Accion de Corto Plazo</th>
			<th colspan="5"  style="color:#FFFFFF" >Indicador</th>
			{{-- <th><img src="{{public_path('img/logosedem.png')}}" alt="logo eba"></th> --}}
		</tr>
		<tr>
			<th colspan="4" style="color:#FFFFFF" >COD PDES</th>
			<th colspan="2" style="color:#FFFFFF" ></th>
			<th colspan="5" style="color:#FFFFFF" ></th>
		</tr>
		<tr>
			<th width="5" style="color:#FFFFFF">P</th>
			<th width="5" style="color:#FFFFFF">M</th>
			<th width="5" style="color:#FFFFFF">R</th>
			<th width="5" style="color:#FFFFFF">A</th>
			<th width="30" style="color:#FFFFFF">Denominacion</th>
			<th width="30" style="color:#FFFFFF">Denominacion</th>
			<th width="30" style="color:#FFFFFF">Descripcion</th>
			<th width="30" style="color:#FFFFFF">Unidad</th>
			<th width="30" style="color:#FFFFFF">Linea Base</th>
			<th width="30" style="color:#FFFFFF">Meta</th>
			<th width="30" style="color:#FFFFFF">Producto Esperado</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($acps as $acp)
		<tr>
			<td>{{ $acp->medium_term_programing->pilar }}</td>
			<td>{{ $acp->medium_term_programing->meta }}</td>
			<td>{{ $acp->medium_term_programing->resultado }}</td>
			<td>{{ $acp->medium_term_programing->accion }}</td>
			<td>{{ $acp->medium_term_programing->descripcion}}</td>
			<td>{{ $acp->descripcion}}</td>
		
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