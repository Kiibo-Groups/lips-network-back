@extends('admin.layout.main')

@section('title')
    Tabla de Clasificaciones
@endsection

@section('content')
    <section class="pull-up">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="card py-3 m-b-30">

                        <div class="card-body">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Score Minimo</th>
                                        <th>Recompensa</th>
                                        <th>Division de posiciones</th>
                                        <th>Fecha de finalizacion</th>
                                        <th style="text-align: right">Opciones</th>
                                    </tr>

                                </thead>
                                <tbody>

                                    @foreach ($data as $row)
                                        <tr>
                                            <td>
                                                <span class="badge badge-soft-secondary">{{ $row->score_min }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-success">${{ number_format($row->reward,2) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-info">%{{ $row->reward_div }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">{{ $row->date_end }}</span>
                                            </td>  
                                            <td style="text-align: right"> 
                                                <button class="btn btn-primary dropdown-toggle" 
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Opciones
                                                </button>
                                        
                                                <ul class="dropdown-menu" style="margin: 0px; position: absolute; inset: 0px auto auto 0px; transform: translate(0px, 38px);" data-popper-placement="bottom-start">
                                                    
                                                    <!-- Wallet -->
                                                    <li>
                                                        <a href="javascript::void()" class="dropdown-item" onclick="confirmAlert('{{ Asset($link . 'cashpool') }}')">
                                                            Repartir CashPool
                                                        </a>
                                                    </li>
                                                    <!-- Wallet -->
                                                    
                                                    <li>
                                                        <a href="{{ Asset($link.'edit') }}" class="dropdown-item">
                                                            Editar
                                                        </a>
                                                    </li>
                                                </ul>
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
