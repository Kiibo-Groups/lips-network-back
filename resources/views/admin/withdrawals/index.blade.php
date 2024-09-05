@extends('admin.layout.main')

@section('title')
    Solicitud de retiros
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
                                        <th>Usuario</th>
                                        <th>Banco</th>
                                        <th>Cuenta</th>
                                        <th>Monto</th>
                                        <th style="text-align: right">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>
                                                &#64;LI0{{ $row->usuario->id }}
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-success">{{ $row->bank }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-success">#{{ $row->account }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-info">${{ number_format($row->amount,2) }}</span>
                                            </td> 
                                            <td style="text-align: right"> 
                                                <button class="btn btn-primary dropdown-toggle" 
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Opciones
                                                </button>
                                        
                                                <ul class="dropdown-menu" style="margin: 0px; position: absolute; inset: 0px auto auto 0px; transform: translate(0px, 38px);" data-popper-placement="bottom-start">
                                                    
                                                    <!-- Wallet -->
                                                    <li>
                                                        <a href="javascript::void()" class="dropdown-item" onclick="confirmAlert('{{ Asset($link . 'changeStatus/'. $row->id) }}')">
                                                            Transferencia realizada
                                                        </a>
                                                    </li>
                                                    <!-- Wallet -->
                                                    
                                                    <li>
                                                        <a href="javascript::void()" class="dropdown-item" onclick="confirmAlert('{{ Asset($link . 'cancelWithdrawal/'. $row->id) }}')">
                                                            Cancelar
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
