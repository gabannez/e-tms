<!--<h1 style="font-size:20pt">User Event Management</h1>-->

	<br />
	<button class="btn btn-success" onClick="add_user_event()"><i class="glyphicon glyphicon-plus"></i> Add User Event</button>
	<button class="btn btn-default" onClick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
	<br /><br />
	<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Real Name</th>
				<th>Event Name</th>
				<th style="width:150px;">Action</th>
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
			"url": "<?php echo site_url('user_event/ajax_list')?>",
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

function add_user_event() 
{
	save_method = 'add';
	$('#form')[0].reset();
	$('.form-group').removeClass('has-error');
	$('.help-block').empty();
	$('#modal_form').modal('show');
	$('.modal-title').text('Add User Event');
}

function edit_user_event(id)
{
	save_method = 'update';
	$('#form')[0].reset();
	$('.form-group').removeClass('has-error');
	$('.help-block').empty();
	
	$.ajax({
		url: "<?php echo site_url('user_event/ajax_edit/')?>/" + id,
		type: "GET",
		dataType: "JSON",
		success: function(data)
		{
			$('[name="id"]').val(data.id);
			$('[name="id_user"]').val(data.id_user);
			$('[name="id_event"]').val(data.id_event);
			$('#modal_form').modal('show');
			$('.modal-title').text('Edit User Event');
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
		url = "<?php echo site_url('user_event/ajax_add')?>";
	} else {
		url = "<?php echo site_url('user_event/ajax_update')?>";
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

function delete_user_event(id)
{
	if(confirm('Are you sure to delete this data?'))
	{
		$.ajax({
			url: "<?php echo site_url('user_event/ajax_delete')?>/"+id,
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
				<h3 class="modal-title">User Event Form</h3>
			</div>
			<div class="modal-body form">
				<form action="#" id="form" class="form-horizontal">
					<input type="hidden" value="" name="id" />
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">User Name</label>
							<div class="col-md-9">
								<select name="id_user" class="form-control">
									<option value="0">------------Select User------------</option>
									<?php foreach($user as $row_user) { ?>
									<option value="<?=$row_user->id?>"><?=$row_user->realname?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Event Name</label>
							<div class="col-md-9">
								<select name="id_event" class="form-control">
									<option value="0">------------Select Event------------</option>
									<?php foreach($event as $row_event) { ?>
									<option value="<?=$row_event->id?>"><?=$row_event->event_name?></option>
									<?php } ?>
								</select>
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