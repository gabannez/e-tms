<div class="panel panel-default">
	<div class="panel-heading"><h3>User Details</h3></div>
	<div class="panel-body">
		<div class="row">
			<label class="control-label col-md-3">Name: <label class="text-info"><?=$user->realname ?></label></label>
			<label class="control-label col-md-3">IC: <label class="text-info"><?=$user->ic ?></label></label>
			<label class="control-label col-md-3">Department: <label class="text-info"><?=$department->name ?></label></label>
			<label class="control-label col-md-3">Position: <label class="text-info"><?=$position->appellation ?></label></label>
			<label class="control-label col-md-3">Email: <label class="text-info"><?=$user->email ?></label></label>
			<label class="control-label col-md-3">Contact No: <label class="text-info"><?=$user->contactNo ?></label></label>
		</div>
		
		<div class="row">
			<label class="control-label col-md-3">&nbsp;</label>
			<label class="control-label col-md-3">&nbsp;</label>
			<label class="control-label col-md-3">&nbsp;</label>
			<label class="control-label col-md-3"><label class="text-danger">No of attended event: <?=$count ?> </label></label>
		</div>
	</div>
	<div class="panel-footer">
		
	