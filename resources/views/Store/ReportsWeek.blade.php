@extends('layout.nativeBase')


@section('title')
    <title>{{ trans('lang.RepositoryViewTitle') }}</title>
@endsection


@section("style")
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="http://127.0.0.1/cdn/datatables-responsive/dataTables.responsive.css">
@endsection

@section("content")

<div class='wrapper'>
 
@if ($StoreType === "restaurant")
 @include('includes.resturantNav')
@else
 @include('includes.sideNav')   
@endif


<div class="StoreContent">
  @include('includes.navbar')
  @include("includes.error")
  
  <div class="Dashboard">
    <div class="OrderTabs">
        <ul>

          @foreach ($Reports as $report)
          <li><a data-toggle="tab" href="#Rweek">{{ $report['ReportName'] }}</a></li> 
          @endforeach
        </ul>
      
        <div class="tab-content OrderTabsCont" style='width: 75%;'>
            
            <div id="Rweek" class="tab-pane fade in ">
               <h4>ready1</h4>
            </div>
            <div id="Rweek2" class="tab-pane fade in ">
                <h4>ready2</h4>
            </div>
            <div id="Rweek3" class="tab-pane fade in ">
             <h4>ready3</h4>
            </div>
 
        </div>
       </div>
     </div>
   </div>
</div>

@endsection
