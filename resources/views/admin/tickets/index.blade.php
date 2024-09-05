@extends('admin.layout.main')

@section('title')
    Tickets
@endsection

@section('content')
    <section class="pull-up">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="card py-3 m-b-30">

                        <div class="row">
                            <div class="col-md-12" style="text-align: right;">
                                <a href="{{ Asset($link.'exportData_tickets') }}" class="btn m-b-15 ml-2 mr-2 btn-rounded btn-warning">
                                    Descargar Excel    
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>#ID</th>
                                        <th>Valor</th>
                                        <th>Score</th>
                                        <th>Categoria Asignada</th>
                                        <th>Status</th>
                                        <th style="text-align: right">Opciones</th>
                                    </tr>

                                </thead>
                                <tbody>

                                    @foreach ($data as $row)
                                        <tr>
                                            <td>
                                                <a href="{{ $row->imagen }}" target="_blank">
                                                    <img src="{{ $row->imagen }}" style="width: 50px;height: 50px;border-radius: 2003px;">
                                                </a>
                                            </td>
                                            <td>
                                                &#64;LI0{{$row->app_user_id}}
                                            </td>
                                            <td>
                                                @if ($row->valor != null)
                                                <span class="badge badge-soft-primary">${{ number_format($row->valor, 2) }}</span>
                                                @else 
                                                <span class="badge badge-soft-danger">$0.00</span>
                                                @endif
                                            </td>
                                            <td>
                                               
                                                @if ($row->score != null)
                                                <span class="badge badge-soft-secondary">{{ $row->score }}</span>
                                                @else 
                                                <span class="badge badge-soft-danger">Sin Score</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->Category)
                                                    <span class="badge badge-soft-dark">{{$row->Category->name}}</span>
                                                @else
                                                <span class="badge badge-soft-danger">Sin asignar</span>
                                                @endif
                                            </td>
                                            <td>

                                                @if ($row->status == 1)
                                                    <span class="badge badge-soft-success">Validado</span>
                                                @elseIf($row->status == 2)
                                                    <span class="badge badge-soft-danger">Denegado</span>
                                                @elseIf($row->status == 3)
                                                    <span class="badge badge-soft-info">Intercambiado</span>
                                                @elseIf($row->status == 0)
                                                    <span class="badge badge-soft-warning">Sin validar</span>
                                                @endif

                                            </td>

                                            <td style="text-align: right"> 
                                                @if ($row->status != 3)
                                                <a href="{{ Asset($link .'view/'. $row->id) }}"
                                                    class="btn m-b-15 ml-2 mr-2 btn-md btn-success"
                                                    data-toggle="tooltip" data-placement="top"
                                                    data-original-title="Editar Ticket"><i
                                                        class="mdi mdi-border-color"></i></a>
                                                @endif
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
