@extends('admin.layout.main')

@section('title')
    Usuarios Registrados
@endsection

@section('icon')
    mdi-home
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
                                        <th>ID</th> 
                                        <th>Fecha de registro</th>
                                        <th>Tickets enviados</th>
                                        <th>Wallet</th>
                                        <th>Score</th>
                                        <th>Estado</th>
                                        <th>Eliminar</th>
                                    </tr>

                                </thead>
                                <tbody>

                                    @foreach ($data as $row)
                                        <tr>
                                            <td>
                                                &#64;LI0{{$row->id}}
                                            </td> 
                                            <td>
                                                <span class="badge bg-warning text-dark">{{ date('d-M-Y', strtotime($row->created_at)) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $row->tickets_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-primary">${{ number_format($row->saldo,2) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-secondary">{{ $row->tickets_sum_score	 }}</span>
                                            </td>
                                            <td>
                                                @if ($row->status == 1)
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        onclick="confirmAlert('{{ Asset($link . 'status/' . $row->id) }}')">Activo</button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="confirmAlert('{{ Asset($link . 'status/' . $row->id) }}')">Bloqueado</button>
                                                @endif
                                            </td>
                                            <td>
                                                 
                                                <button class="btn btn-primary dropdown-toggle" 
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Opciones
                                                </button>
                                        
                                                <ul class="dropdown-menu" style="margin: 0px; position: absolute; inset: 0px auto auto 0px; transform: translate(0px, 38px);" data-popper-placement="bottom-start">
                                                    
                                                    <!-- Wallet -->
                                                    <li>
                                                        <a href="{{ Asset($link.$row->id.'/wallet') }}" class="dropdown-item">
                                                            Agregar Saldo
                                                        </a>
                                                    </li>
                                                    <!-- Wallet -->
                                                    
                                                    <li>
                                                        <a href="javascript::void()" class="dropdown-item" onclick="deleteConfirm('{{ Asset($link . 'trash/' . $row->id) }}')">
                                                            Eliminar
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

                    {!! $data->links() !!}

                </div>
            </div>
        </div>
    </section>
@endsection
