@extends('layouts.app')

@section('title', 'Titulo de la págia')

@section('page-title', 'Dashboard')

@section('css')
    <!-- Custom CSS files here-->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @if (count($proyectos) > 0)
                @foreach ($proyectos as $proyecto)
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                        <div class="card 
                @if ($proyecto->activo) card-success @else card-danger @endif
                card-outline"
                            >
                            <div class="card-header text-center">
                                <h5 style="margin-top: 13px">{{ $proyecto->nombre }}</h5>
                            </div>
                            <div class="card-body" style="overflow-y: auto;">
                                <div class="scroll-container">
                                    <p class="card-text text-justify scroll-container">Monto Asignado al proyecto: ${{ $proyecto->monto }}</p>
                                    {{-- @foreach ($proyecto->qrs as $qr)
                                <li><label class="badge badge-primary"> {{ $qr->etiqueta }}</label> - <a
                                        href="{{ $qr->redireccion }}" target="_blank"><i class="fa fa-link"></i>
                                        Revisar Link</a></li>
                            @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    No hay proyectos registrados
                </div>
            @endif


        </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">{titulo}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <p>{contenido}</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('scripts')
    <!-- Custom JS files here -->

    <!-- QR -->
    <script src="{{ asset('dist/js/md5.min.js') }}"></script>
    <script src="{{ asset('dist/js/qr.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        // Inicializa el arreglo que contendrá los proyectos
        const listaProyectos = [];

        @foreach ($proyectos as $proyecto)
            // Agrega cada proyecto al arreglo, incluyendo la cuenta de QRs
            listaProyectos.push({
                id: '{{ $proyecto->id }}',
                nombre: '{{ $proyecto->nombre }}',
                monto: '{{ $proyecto->monto }}',
            });
        @endforeach
    </script>
@endsection