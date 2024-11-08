@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.products')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ Route('dashboard.index') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{ Route('dashboard.products.index') }}"><i class="fa fa-dashboard"></i>@lang('site.products')</a>
                </li>
                <li class="active"><i class="fa fa-dashboard"></i>@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">
                    @include('partials._errors')

                    <form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group">
                            <label>@lang('site.categories')</label>
                            <select name="category_id" class="form-control">
                                <option value="">@lang('site.all_categories')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name_ar" class="form-control" value="{{ $product->name_ar }}" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.description')</label>
                            <textarea name="description_ar" class="form-control " required>{{ $product->description_ar }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name_en" class="form-control" value="{{ $product->name_en }}" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.description')</label>
                            <textarea name="description_en" class="form-control " required>{{ $product->description_en}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="">@lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('uploads/product_images/' . $product->image) }}" style="width: 100px" class="img-thumbnail image-preview" alt="">
                        </div>

                        <div class="form-group">
                            <label for="">@lang('site.purchase_price')</label>
                            <input type="number" name="purchase_price" class="form-control" value="{{ $product->purchase_price }}">
                        </div>

                        <div class="form-group">
                            <label for="">@lang('site.sale_price')</label>
                            <input type="number" name="sale_price" class="form-control" value="{{ $product->sale_price }}">
                        </div>

                        <div class="form-group">
                            <label for="">@lang('site.stock')</label>
                            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.edit')</button>
                        </div>
                    </form><!-- end of form -->
                </div><!-- end of box body -->
            </div><!-- end of box primary-->
        </section>
    </div>
@endsection
