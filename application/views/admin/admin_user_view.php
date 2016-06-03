,<!--<h1 style="font-size:20pt">User Management</h1>-->

	<br />
	<button class="btn btn-success" onClick="add_user()"><i class="glyphicon glyphicon-plus"></i> Add User</button>
	<button class="btn btn-default" onClick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
	<br /><br />
	<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Username</th>
				<th>Level</th>
				<th>Real Name</th>
				<th>IC</th>
				<th>Department</th>
				<th>Position</th>
				<th>email</th>
				<th>Contact No</th>
				<th style="width:160px;">Action</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		
		<tfoot>
		</tfoot>
	</table>
</div>
	
<script type="text/javascript">

var save_method;
var table;

$(document).ready(function() {
	
	table = $('#table').DataTable({
		
		"processing": true,
		"serverSide": true,
		"order": [],
		
		"ajax": {
			"url": "<?php echo site_url('user/ajax_list')?>",
			"type": "POST"
		},
		
		"columnDefs": [
		{
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});
});

function add_user() 
{
	save_method = 'add';
	$('#form')[0].reset();
	$('.form-group').removeClass('has-error');
	$('.help-block').empty();
	$('#modal_form').modal('show');
	$('.modal-title').text('Add User');
}

function edit_user(id)
{
	save_method = 'update';
	$('#form')[0].reset();
	$('.form-group').removeClass('has-error');
	$('.help-block').empty();
	$('#password').attr('readonly', 'readonly');
	$('#cpassword').hide();
	
	$.ajax({
		url: "<?php echo site_url('user/ajax_edit/')?>/" + id,
		type: "GET",
		dataType: "JSON",
		success: function(data)
		{
			$('[name="id"]').val(data.id);
			$('[name="username"]').val(data.username);
			$('[name="password"]').val(data.password);
			$('[name="level"]').val(data.level);
			$('[name="realname"]').val(data.realname);
			$('[name="ic"]').val(data.ic);
			$('[name="department"]').val(data.department);
			$('[name="position"]').val(data.position);
			$('[name="email"]').val(data.email);
			$('[name="contactNo"]').val(data.contactNo);
			$('#modal_form').modal('show');
			$('.modal-title').text('Edit User');
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			alert('Error get data from ajax');
		}
	});
}

function reload_table()
{
	table.ajax.reload(null,false);
}

function save()
{
	var url;
	
	if(save_method == 'add') {
		url = "<?php echo site_url('user/ajax_add')?>";
	} else {
		url = "<?php echo site_url('user/ajax_update')?>";
	}
	
	$.ajax({
		url: url,
		type: "POST",
		data: $('#form').serialize(),
		dataType: "JSON",
		success: function(data)
		{
			$('#modal_form').modal('hide');
			reload_table();
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			alert('Error adding / update data');
		}
	});
}

function delete_user(id)
{
	if(confirm('Are you sure to delete this data?'))
	{
		$.ajax({
			url: "<?php echo site_url('user/ajax_delete')?>/"+id,
			type: "POST",
			dataType: "JSON",
			success: function(data)
			{
				$('#modal_form').modal('hide');
				reload_table();
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				alert('Error deleting data');
			}
		});
	}
}

</script>

<!-- Bootstrap Modal -->
<div class="modal fade" id="modal_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">User Form</h3>
			</div>
			<div class="modal-body form">
				<form action="#" id="form" class="form-horizontal">
					<input type="hidden" value="" name="id" />
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Username</label>
							<div class="col-md-9">
								<input name="username" placeholder="Username" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Password</label>
							<div class="col-md-9">
								<input name="password" id="password" placeholder="**********" class="form-control" type="password">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group" id="cpassword">
							<label class="control-label col-md-3">Confirm Password</label>
							<div class="col-md-9">
								<input name="cpassword" placeholder="**********" class="form-control" type="password">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Level</label>
							<div class="col-md-9">
								<select name="level" class="form-control">
									<option value="0">------------Select Level------------</option>
									<?php foreach($role as $row_role) { ?>
									<option value="<?=$row_role->id?>"><?=$row_role->description?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Real Name</label>
							<div class="col-md-9">
								<input name="realname" placeholder="Real Name" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">IC No.</label>
							<div class="col-md-9">
								<input name="ic" placeholder="No. MyKad/MyPR" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Department</label>
							<div class="col-md-9">
								<select name="department" class="form-control">
									<option value="0">------------Select Department------------</option>
									<?php foreach($department as $row_department) { ?>
									<option value="<?=$row_department->id?>"><?=$row_department->name?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Position</label>
							<div class="col-md-9">
								<select name="position" class="form-control">
									<option value="0">------------Select Position------------</option>
									<?php foreach($position as $row_position) { ?>
									<option value="<?=$row_position->id?>"><?=$row_position->appellation?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Email</label>
							<div class="col-md-9">
								<input name="email" placeholder="Email" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Contact No</label>
							<div class="col-md-9">
								<input name="contactNo" placeholder="H/P Or Office Tel. No" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnSave" onClick="save()" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
</body>
</html>