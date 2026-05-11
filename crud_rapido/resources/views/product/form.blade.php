<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group mb-3">
            <label for="description">{{ __('Descripción') }}</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $product?->description) }}" placeholder="Descripción del producto" required>
            {!! $errors->first('description', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="price">{{ __('Precio') }}</label>
            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product?->price) }}" placeholder="0.00" required>
            {!! $errors->first('price', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="stock">{{ __('Stock') }}</label>
            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product?->stock) }}" placeholder="Cantidad disponible" required>
            {!! $errors->first('stock', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="box-footer mt-3">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>