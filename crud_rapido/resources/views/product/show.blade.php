@extends('layouts.app')

@section('template_title')
    {{ $product->description ?? __('Show') . " " . __('Product') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Detalle del Producto') }}</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('products.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mt-2">
                            <strong>Descripción:</strong>
                            {{ $product->description }}
                        </div>
                        <div class="form-group mb-2">
                            <strong>Precio:</strong>
                            {{ $product->price }}
                        </div>
                        <div class="form-group mb-2">
                            <strong>Stock:</strong>
                            {{ $product->stock }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection