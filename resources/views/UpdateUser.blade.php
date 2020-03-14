@extends('layout.nativeBase')


@section("content")
<div class='wrapper'>
@include('includes.DashboardNav')
   
  <div class='StoreContent'>
   @include('includes.navbar')
   @include('includes.error')
   
 
    
     <div class="row Dashboard2">

      <div class="col-sm-12 col-md-12 col-xs-12">
      <div class="panel">
        <div class="panel-body">
          <form action="" method="post" class="form-horizontal">
      
            <div class="form-group">
              <div class="col-sm-2"><label for="FullNameI">Full Name:</label></div>
              <div class="col-sm-6"><input type="text" name="FullNameI" value='{{$User['StoreFullName']}}'  class="form-control"></div>
            </div>
            <div class="form-group">
              <div class="col-sm-2"><label for="UsreNameI">User Name:</label></div>
              <div class="col-sm-6"><input type="text" name="UserNameI" value='{{$User['StoreUserName']}}'  class="form-control"></div>
            </div>
            <div class="form-group">
              <div class="col-sm-2"><label for="AddressI">Address:</label></div>
              <div class="col-sm-6"><input type="text" name="AddressI" value='{{$User['StoreAddress']}}' class="form-control"></div>
            </div>
    
            <div class="form-group">
              <div class="col-sm-2"><label for="EmailI">Email :</label></div>
              <div class="col-sm-6"><input type="text" name="EmailI" value='{{$User['StoreEmail']}}'  class="form-control"></div>
            </div> 
           <div class="form-group">
             <input type="hidden" name="UserId" value="{{ $User['id']}}">
            
             {{ csrf_field()}}
               <!-- Modal -->
      <div class="modal fade" id="UpdateUser" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Update User</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <div class="col-md-3"><label for="passwordI">Password:</label></div>
                <div class="col-sm-6"><input type="password" name="PasswordI" class="form-control"></div>
              </div>
              <div class="form-group">
                <div class="col-sm-3"><label for="Password2I">Repeat Password:</label></div>
                <div class="col-sm-6"><input type="password" name="Password2I" class="form-control"></div>
              </div>
    
            </div>
            <div class="modal-footer">
              <input type="submit" value="Update" class="btn btn-primary">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
      </div>
    </div>
          </form>
          <div class="col-sm-3 col-sm-offset-2"><button data-toggle="modal" data-target="#UpdateUser" value="Update" class="btn btn-primary">Update</button></div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-12 col-xs-12">
      <div class="panel">
        <div class="panel-body">


          <form action="{{route("SetApi")}}" method="post" class="form-horizontal">

          <div class="form-group">
            <div class="col-sm-2"><label for="ApiPublish">Api Publish :</label></div>
            <div class="col-sm-6"><input type="text" name="ApiPublish" value='{{ $ApiKey['ApiPub']}}'  class="form-control"></div>
          </div>
          <div class="form-group">
            <div class="col-sm-2"><label for="ApiSecret">Api Seceret :</label></div>
            <div class="col-sm-6"><input type="text" name="ApiSecret" value='{{ $ApiKey['ApiSeceret']}}' class="form-control"></div>
          </div>
          <div class="form-group">
           <div class="col-sm-offset-2 col-sm-3">
             {{ csrf_field()}}
           <input type="submit" value="Update Stripe Key" class="btn btn-primary">   
          </div>  
          </div>  
        </form> 

        </div>
      </div>
    </div>




      </div>
     </div>



</div>
@endsection

@section('script')
   
@endsection

