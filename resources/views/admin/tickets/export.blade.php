<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<table>
  <thead>
    <tr>
      <td><b>ID</b></td>
      <td><b>Ticket</b></td>
      <td><b>Usuario</b></td>
      <td><b>Email</b></td>
      <td><b>Valor del ticket</b></td>
      <td><b>Score Acumulado</b></td>
      <td><b>Tickets Enviados</b></td> 
      <td><b>Categoria asignada</b></td> 
    </tr>
  </thead>
  <tbody>
    @foreach($data as $row)
    <tr>
      <td>#{{ $row->id }}</td>
      <td>
        <a href="{{ $row->imagen }}">{{ $row->imagen }}</a>
      </td>
      <td>
        &#64;LI0{{$row->app_user_id}}
      </td>
      <td>{{ $row->usuario->email }}</td>
      <td>${{ number_format($row->valor,2) }}</td>
      <td>{{ $row->tickets_sum_score }}</td>
      <td>{{ $row->tickets_count }}</td>
      <td>{{ $row->Category }}</td>
    </tr>
@endforeach   
  </tbody>
</table>
 
 
</body>
</html>