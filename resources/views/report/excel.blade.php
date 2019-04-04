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
            @foreach ($columns as $col)
                <th  style="color:#FFFFFF" >{{$col->label}}</th>
            @endforeach

			{{-- <th><img src="{{public_path('img/logosedem.png')}}" alt="logo eba"></th> --}}
		</tr>

	</thead>
	<tbody>
            @foreach ($rows as $row)
            <tr class="content">
                <td>{{ $row->month }}</td>
                <td>{{ $row->meta }}</td>
                <td>{{ $row->executed }}</td>
                <td>{{ $row->efficacy }}</td>
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
