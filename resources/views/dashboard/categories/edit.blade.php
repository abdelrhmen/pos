@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ Route('dashboard.index') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{ Route('dashboard.categories.index') }}"><i class="fa fa-dashboard"></i>@lang('site.categories')</a></li>
                <li class="activ"><i class="fa fa-dashboard"></i>@lang('site.edit')</a></li>
            </ol>

        </section>


        <section class="content">


            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post">

                        {{ csrf_field() }}
                        {{ method_field('put') }}



                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label for="">@lang('site.' . $locale . '.name')</label>
                                <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ old( $locale .'.name') }}">
                            </div>
                        @endforeach



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-edit"></i>@lang('site.edit')</button>
                        </div>
                    </form><!-- end of form -->



                </div><!-- end of box body -->

            </div><!-- end of box primary-->

        </section>

    </div>
@endsection
