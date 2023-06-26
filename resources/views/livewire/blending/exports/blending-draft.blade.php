<table cellpadding="4" border="1">
    <thead>
        <tr height="50">
            <th align="center" colspan="14">REPORTE DE MINERALES EXISTENTES EN EL DEPOSITO</th>
        </tr>
        <tr></tr>
        <tr>
            <th rowspan="2" bgcolor="#cccccc">Fecha de Ingreso</th>
            <th rowspan="2" bgcolor="#cccccc">Lote</th>
            <th rowspan="2" bgcolor="#cccccc">Cliente</th>
            <th rowspan="2" bgcolor="#cccccc">Tipo de Mineral</th>
            <th colspan="3" bgcolor="#cccccc">Leyes</th>
            <th rowspan="2" bgcolor="#cccccc">PESO</th>
            <th rowspan="2" bgcolor="#cccccc">LIBRAS CU</th>
            <th rowspan="2" bgcolor="#cccccc">ONZAS AU</th>
            <th rowspan="2" bgcolor="#cccccc">ONZAS AG</th>
            <th rowspan="2" bgcolor="#cccccc">AS</th>
            <th rowspan="2" bgcolor="#cccccc">SB</th>
            <th rowspan="2" bgcolor="#cccccc">H20</th>
        </tr>
        <tr>
            <th bgcolor="#cccccc">CU</th>
            <th bgcolor="#cccccc">AU</th>
            <th bgcolor="#cccccc">AG</th>
        </tr>
    </thead>
    <tbody>
    @foreach($settlements as $settlement)
        <tr>
            <td align="center">{{ $settlement->date }}</td>
            <td align="center">{{ $settlement->batch }}</td>
            <td>{{ $settlement->Order->Client->name }}</td>
            <td align="center">{{ $settlement->Order->Concentrate->concentrate }}</td>
            <td>{{ $settlement->Law->copper }}</td>
            <td>{{ $settlement->Law->silver }}</td>
            <td>{{ $settlement->Law->gold }}</td>
            <td>{{ $settlement->Order->wmt }}</td>
            <td>{{ $settlement->Law->copper }}</td>
            <td>{{ $settlement->Law->silver }}</td>
            <td>{{ $settlement->Law->gold }}</td>
            <td>{{ $settlement->Penalty->arsenic }}</td>
            <td>{{ $settlement->Penalty->antomony }}</td>
            <td>{{ $settlement->Law->humidity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
