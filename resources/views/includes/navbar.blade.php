<nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#NavbarCollapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <div class="navbar-brand">
        <button id='SideNavCollapse' class="navbar-toggle SideNavCollapse" name='SideNavCollapse'>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      </div>
  
  <div class="collapse navbar-collapse" id="NavbarCollapse">
  @if( str_replace('_','-',app()->getLocale()) == 'ar' )
    <ul class="nav navbar-nav navbar-left">
  @else
   <ul class="nav navbar-nav navbar-right">
  @endif
      <li class="UserBtn active dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="{{ url("/inc/images/avatar.png") }}" class='img-circle' style='height:20px' ><h3>{{ $UserInf['StoreFullName']}}</h3></a>
 @if( str_replace('_','-',app()->getLocale()) == 'ar' )
 <ul class="dropdown-menu dropdown-menu-left">
  @else
  <ul class="dropdown-menu dropdown-menu-right">
  @endif
          <li><a href="{{route("UpdateUser")}}">Update</a></li>
          <li><a href="{{route('LogOut')}}" >Log Out<span class="glyphicon glyphicon-off"></span> </a></li>
        </ul>
      </li>

      <li class="dropdown "><a class="dropdown-toggle NotifBtn" data-toggle="dropdown" href="javascript:void(0)"><span class="glyphicon glyphicon-bell"></span></a>
        @if( str_replace('_','-',app()->getLocale()) == 'ar' )
        <ul class="dropdown-menu dropdown-menu-left NotifDropdown">
          @else
          <ul class="dropdown-menu dropdown-menu-right NotifDropdown">
          @endif
          @if ($UserInf['PlanDayLeft'] < "4")
          <li class='NotifElErr' style="">Day Left {{$UserInf['PlanDayLeft']}}</li>
          @endif



          @foreach ($Notifs as $notif)
          @if ($notif['NotifStatus'] == "0")
          <li class='NotifElNew'>{{ $notif['NotifValue'] }}</li>
          @else
          <li class='NotifEl'>{{ $notif['NotifValue'] }}</li>
          @endif
          @endforeach
         
        </ul>
      </li>
    </ul>
  </div>
    </div>
  </nav>


