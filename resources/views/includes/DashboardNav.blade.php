<nav id="sidebar">
    <div class="sidebar-header">
        <h3>Bootstrap Sidebar</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="active">
        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"> {{ trans("lang.SideNavStores") }}  </a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
              <li><a href="{{ route("Dashboard") }}">{{ trans("lang.SideNavStoreList")}}</a></li>                   
              <li><a href="# " data-toggle="modal" data-target="#AddStore">{{ trans("lang.SideNavAddStore") }}</a></li>
              <li><a href="{{ route("DelStore") }}">{{ trans("lang.SideNavDelStore") }}</a></li>
            </ul>
        </li>
    </ul>

</nav>



  <!-- Modal -->
  <div class="modal fade" id="AddStore" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body" style="height:195px">

        <form class='form-horizontal' method="POST" action="{{ route("AddStore") }}" >
                  <div class="form-group">
                    <div class="col-sm-3"><label for="StoreNameI" class="form-label"> StoreName:</label></div>
                    <div class="col-sm-6"><input type="text" name="StoreNameI"  class="form-control"></div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-3"><label for="StoreTypeI" class="form-label"> StoreType:</label></div>
                    <div class="col-sm-4"><select name="StoreTypeI"  class="form-control">
                     <option value="restaurant"> restaurant</option>   
                     <option value="pharmasy">pharmasy</option> 
                     <option value="electronics">electronics and technology</option>
                    </select></div>
                  </div>
                  {{ csrf_field() }}
                  <div class="col-sm-3 col-sm-offset-3"><input type="submit"  class="btn btn-primary"></div>           
                 </form>
        
        </div>
      </div>
    </div>
  </div>