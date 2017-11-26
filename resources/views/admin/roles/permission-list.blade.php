<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-10">
	<div class="body">

	<!-- Permission Section Button -->
		<p class="dropdown list-group-item list-group-bg-cyan "  >
			{!! Form::checkbox('role_permissions_group[]',1,($role->permissions->where('section',$section)->count()==count($pl)) ,['class'=>'filled-in chk-col-brown','id'=>'role_permissions_group_'.$role->id.'_'.$section]) !!} 
			
			<label for="role_permissions_group_{!!$role->id!!}_{!!$section!!}">{!! title_case($section) !!}
			<b>Assigned (<span class="assigned">{!!$role->permissions->where('section',$section)->count()!!}</span>/<span class="total">{!!count($pl)!!}</span>)</b>

			</label>
			
			
			<a class="pull-right" href="javascript:;" data-toggle="collapse" data-target="#role_permissions_group_collapse_{!!$section!!}_{!!$role->id!!}" aria-expanded="false"  aria-controls="role_permissions_group_collapse"><i class="material-icons">add</i></a>
		</p>
	<!-- End Permission Section List -->

	<!-- Permission List under the collapse elements-->	

		<div class="collapse role_permissions_group_collapse" id="role_permissions_group_collapse_{!!$section!!}_{!!$role->id!!}">
	        <ul class="list-group" data-length="{!!count($pl)!!}">
	        
	        @foreach($pl as $p)

	            <li class="list-group-item" title="{!!$p->description!!}">
	            	{!! Form::checkbox('allow_permissions[]',$p->id,$role->permissions->whereIn('id',$p->id)->isNotEmpty(),['class'=>'chk-col-light-blue allow_permissions','id'=>'allow_permissions_'.$role->id.'_'.$p->id]) !!} 
	            	<label for="allow_permissions_{!!$role->id!!}_{!!$p->id!!}">{!!$p->title!!} <small class="font-italic col-blue-grey">{!!$p->description!!}</small></label>
	            </li>
	        @endforeach                     
	        </ul>
		</div>
	<!-- End Permission List -->	

	</div>

</div>