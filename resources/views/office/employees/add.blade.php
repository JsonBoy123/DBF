<form id="employee_form" class="form-horizontal" method="post">
    @csrf
    
    <ul class="nav nav-tabs nav-justified" data-tabs="tabs">
       <li class="active" role="presentation">
          <a data-toggle="tab" href="#employee_basic_info">Information</a>
       </li>
       <li role="presentation">
          <a data-toggle="tab" href="#employee_login_info">Login</a>
       </li>
       <li role="presentation">
          <a data-toggle="tab" href="#employee_permission_info">Permissions</a>
       </li>
    </ul>
    <div class="tab-content">
       <div class="tab-pane fade in active" id="employee_basic_info">
          <fieldset>
             <div class="form-group form-group-sm">
                <label for="first_name" class="required control-label col-xs-3" aria-required="true">First Name</label>	
                <div class="col-xs-8">
                   <input type="text" name="first_name" value="{{ old('first_name') }}" id="first_name" class="form-control input-sm">
                @error('first_name')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                   @enderror
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="last_name" class="required control-label col-xs-3" aria-required="true">Last Name</label>	
                <div class="col-xs-8">
                   <input type="text" name="last_name" value="{{ old('last_name') }}" id="last_name" class="form-control input-sm">
                   @error('last_name')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                   @enderror
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="gender" class="control-label col-xs-3">Gender</label>	
                <div class="col-xs-4">
                   <label class="radio-inline">
                   <input type="radio" name="gender" value="0" id="gender">
                   M		</label>
                   <label class="radio-inline">
                   <input type="radio" name="gender" value="1" id="gender">
                   F		</label>
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="email" class="control-label col-xs-3">Email</label>	
                <div class="col-xs-8">
                   <div class="input-group">
                      <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-envelope"></span></span>
                      <input type="text" name="email" value="{{ old('email') }}" id="email" class="form-control input-sm">
                   @error('email')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                   @enderror
                   </div>
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="phone_number" class="required control-label col-xs-3" aria-required="true">Phone Number</label>	
                <div class="col-xs-8">
                   <div class="input-group">
                      <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
                      <input type="text" name="phone_number" value="{{ old('phone_number') }}" id="phone_number" class="form-control input-sm">
                  @error('phone_number')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                   @enderror
                   </div>
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="address_1" class="control-label col-xs-3">Address 1</label>	
                <div class="col-xs-8">
                   <input type="text" name="address_1" value="{{ old('address_1') }}" id="address_1" class="form-control input-sm">
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="address_2" class="control-label col-xs-3">Address 2</label>	
                <div class="col-xs-8">
                   <input type="text" name="address_2" value="{{ old('address_2') }}" id="address_2" class="form-control input-sm">
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="city" class="control-label col-xs-3">City</label>	
                <div class="col-xs-8">
                   <input type="text" name="city" value="{{ old('city') }}" id="city" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="state" class="control-label col-xs-3">State</label>	
                <div class="col-xs-8">
                   <input type="text" name="state" value="{{ old('state') }}" id="state" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="zip" class="control-label col-xs-3">Postal Code</label>	
                <div class="col-xs-8">
                   <input type="text" name="zip" value="{{ old('zip') }}" id="postcode" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="country" class="control-label col-xs-3">Country</label>	
                <div class="col-xs-8">
                   <input type="text" name="country" value="{{ old('country') }}" id="country" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="comments" class="control-label col-xs-3">Comments</label>	
                <div class="col-xs-8">
                   <textarea name="comments" cols="40" rows="10" id="comments" class="form-control input-sm">{{ old('comments') }}</textarea>
                </div>
             </div>	
          </fieldset>
       </div>

       <div class="tab-pane" id="employee_login_info">
          <fieldset>
             <div class="form-group form-group-sm">
                <label for="username" class="required control-label col-xs-3" aria-required="true">Username</label>					
                <div class="col-xs-8">
                   <div class="input-group">
                      <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-user"></span></span>
                      <input type="text" name="username" id="username" class="form-control input-sm">
                   @error('username')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                   @enderror
                   </div>
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="password" class="control-label col-xs-3">Password</label>					
                <div class="col-xs-8">
                   <div class="input-group">
                      <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-lock"></span></span>
                      <input type="password" name="password" value="" id="password" class="form-control input-sm">
                   @error('password')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                   @enderror
                   </div>
                </div>
             </div>
             <div class="form-group form-group-sm">
                <label for="repeat_password" class="control-label col-xs-3">Password Again</label>					
                <div class="col-xs-8">
                   <div class="input-group">
                      <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-lock"></span></span>
                       <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                   </div> 
                </div>
             </div>
          </fieldset>
       </div>
       <div class="tab-pane" id="employee_permission_info">
          <select class="form-control" id="getpermission">
             <option>Select..</option>
             @foreach($module as $Module)
                <option value="{{$Module->id}}">{{$Module->name}}</option>
             @endforeach   
          </select>
          <hr>
          <div id="allpermission">
             
          </div>
       </div>
    	<button class="btn btn-primary" style="float: right" id="submit">Submit</button>
    </div>
 </form>