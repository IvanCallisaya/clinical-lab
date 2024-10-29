@extends('include.master')


@section('title','Inventory | Clientes')


@section('page-title','Todos los clientes')


@section('content')


        <div class="row clearfix">
        	
        	<create-member></create-member>

        </div>


        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                        <!--     <h2>
                                Vendor List
                          
                            </h2> -->
                          
                          <h2>
                          	 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-member">
                                Asociado nuevo
                             </button>
                          </h2>
                        </div>

                        <view-member></view-member>

                    </div>
                </div>
            </div>

          


@endsection

@push('script')

<script type="text/javascript" src="{{ url('public/js/member.js') }}"></script>

@endpush