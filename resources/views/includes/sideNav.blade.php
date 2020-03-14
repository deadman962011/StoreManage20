         <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Bootstrap  
                  @if (str_replace('_','-',app()->getLocale()) == 'ar')
                  <button id='SideNavCollapse' class="SideNavCollapse visible-xs" style='float:left' name='SideNavCollapse'><span class='glyphicon glyphicon-remove'></span></button></h3>
                  @else
                  <button id='SideNavCollapse' class="SideNavCollapse visible-xs" style='float:right' name='SideNavCollapse'><span class='glyphicon glyphicon-remove'></span></button></h3>
                  @endif
                
                
            </div>

            <ul class="list-unstyled components">
              <li><a href="{{ route("StoreMain",['StoreType'=>$StoreType,'StoreId'=>$StoreId]  )}}"><span class="	glyphicon glyphicon-stats"></span>  {{ trans("lang.SideNavStatitics") }}</a></li>
              <li><a href="{{ route("StorePos",['StoreType'=>$StoreType,'StoreId'=>$StoreId]  ) }}"><span class="glyphicon glyphicon-dashboard"></span>    Pos    </a></li>
                <li><a href="{{ route("Sales",['StoreType'=>$StoreType,'StoreId'=>$StoreId]  ) }}"><span class="glyphicon glyphicon-usd"></span>    {{trans("lang.SideNavSales")}}    </a></li>
                <li >
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"><span class="glyphicon glyphicon-shopping-cart"></span> {{ trans("lang.SideNavStores") }}</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li><a href="{{ route("Dashboard") }}">{{ trans("lang.SideNavStoreList")}}</a></li> 
                        <li><a href="# " data-toggle="modal" data-target="#AddStore">{{ trans("lang.SideNavAddStore") }}</a></li>
                        <li><a href="{{ route("DelStore") }}">{{ trans("lang.DashBoardDelStore") }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false"><span class="glyphicon glyphicon-apple"></span>    {{ trans("lang.SideNavResources") }}    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li><a href="{{ route("Products",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}">    {{ trans("lang.SideNavProds") }}</a></li>
                        <li><a href="{{ route("Catigories",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}">    {{ trans("lang.SideNavCats")}}</a></li>
                    </ul>  
                </li>
                <li>
                    <a href="#employeeSubmenu" data-toggle="collapse" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>    {{ trans("lang.SideNavEmps")}}</a>
                    <ul class="collapse list-unstyled" id="employeeSubmenu">
                        <li><a href="{{ route("Employee",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}">{{ trans("lang.SideNavEmpsList") }}</a></li>
                        <li><a href="javascript:void" data-toggle="modal" data-target="#AddEmp">{{ trans("lang.SideNavEmpAdd") }}</a></li>
                    </ul>  
                </li>
                <li>
                    <a href="#repositories" data-toggle="collapse" aria-expanded="false"><span class="	glyphicon glyphicon-download-alt"></span>    {{trans("lang.SideNavRepos")}}</a>
                    <ul class="collapse list-unstyled" id="repositories">
                        <li><a href="{{ route("Repository",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}">{{trans("lang.SideNavRepoList")}}</a></li>
                        <li><a href="# " data-toggle="modal" data-target="#AddRepo">{{trans("lang.SideNavRepoAdd")}}</a></li>
                    <li><a href="{{ route("DelRepo",['StoreType'=>$StoreType,'StoreId'=>$StoreId])}}" >{{trans("lang.SideNavRepoDel")}}</a></li>
                    </ul>  
                </li>
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

  

        <!-- Add new employee Modal -->
        <div class="modal fade" id="AddEmp" role="dialog">
          <div class="modal-dialog">
          
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Employee</h4>
              </div>
              <div class="modal-body">
                <form action="{{ route("AddEmployee",["StoreType"=>$StoreType,"StoreId"=>$StoreId]) }}"  method="post">
      
                  <br>
                  <input type="text" name="EmpNameI"     placeholder="Employee Name" class="form-control">
                  <br>
      
                  <br>
                  <input type="text" name="EmpAgeI"     placeholder="Employee Age" class="form-control">
                  <br>          
      
                  <br>
                  <select name="EmpGenderI"  class="form-control">
                     <option value="male">Male</option> 
                     <option value="female">female</option> 
                  </select>
                  <br>
                  
                  <br>
                  <select name="EmpMaritalStatusI"  class="form-control">
                       <option value="single">single</option> 
                       <option value="married">married</option>
                       <option value="engaged">engaged</option> 
                    </select>
                    <br>
      
                    <br>
                    <input   type="text" name="EmpFeeI" placeholder="Employee Fee Per Month"  class="form-control">
                    <br>
                    <br>
                    <select name="EmpTypeI" class='form-control'>
                      <option value="Delivery">Delivery</option>
                      <option value="Casher">Casher</option>
                      @if ($StoreType === "restaurant")
                       <option value="Waiter">Waiter</option>
                      @endif
                      <option value="NoSel"> Un Selected</option>
        
                    </select>
                  {{ csrf_field() }}
              </div>
              <div class="modal-footer">
                <input  type='submit' class="btn btn-primary pull-left ">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </form>
              </div>
            </div>
            
          </div>
        </div>
  


   <!-- Modal -->
 <div class="modal fade" id="AddRepo" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body" style="height:195px">

        <form class='form-horizontal' method="POST" action="{{ route("AddRepo",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}" >
                  <div class="form-group">
                    <div class="col-sm-3"><label for="RepoNameI" class="form-label"> Repository Name:</label></div>
                    <div class="col-sm-6"><input type="text" name="RepoNameI"  class="form-control"></div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-3"><label for="RepoAddressI" class="form-label"> Repository Address:</label></div>
                    <div class="col-sm-6"><input type="text" name="RepoAddressI"  class="form-control"></div>
                  </div>
                  {{ csrf_field() }}
                  <div class="col-sm-3 col-sm-offset-3"><input type="submit"  class="btn btn-primary"></div>           
                 </form>
        </div>
      </div>
    </div>
  </div>