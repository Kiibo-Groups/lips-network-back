@extends('admin.layout.main')

@section('title')
    Recompensas
@endsection

@section('content')
    <section class="pull-up">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="card py-3 m-b-30">
                        <div class="card-header">
                            <span class="bg-info alert text-white">Estas recompensas se generan al término de una Clasificacion en la tabla de <a href="{{ url(env('admin').'/leaderboard') }}">LeaderBoard</a></span>
                        </div>

                        <div class="card-body">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Ganador</th>
                                        <th>Lugar Ganador</th>
                                        <th>Recompensa</th>
                                        <th>Fecha de sorteo</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>
                                                &#64;LI0{{ $row->usuario->id }}
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-success"># {{ $row->place_reward }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-info">${{ number_format($row->reward,2) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">{{ $row->date_reward }}</span>
                                            </td>   
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
