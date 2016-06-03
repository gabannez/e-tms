<!--<h1 style="font-size:20pt">Event Management</h1>-->

	<br />
	<button class="btn btn-success" onClick="add_event()"><i class="glyphicon glyphicon-plus"></i> Add Event</button>
	<button class="btn btn-default" onClick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
	<br /><br />
	<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Event Type</th>
				<th>Event Name</th>
				<th>Location</th>
				<th>Date Start</th>
				<th>Date End</th>
				<th>Time Start</th>
				<th>Time End</th>
				<th>Remarks</th>
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
			"url": "<?php echo site_url('event/ajax_list')?>",
			"type": "POST"
		},
		
		"columnDefs": [
		{
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});
	
	//datepicker
	$('.datepicker').datepicker({
		autoclose: true,
		format: "yyyy-mm-dd",
		todayHighlight: true,
		orientation: "bottom auto",
		todayBtn: true,
		todayHighlight: true,
	});
});

function add_event() 
{
	save_method = 'add';
	$('#form')[0].reset();
	$('.form-group').removeClass('has-error');
	$('.help-block').empty();
	$('#modal_form').modal('show');
	$('.modal-title').text('Add Event');
}

function edit_event(id)
{
	save_method = 'update';
	$('#form')[0].reset();
	$('.form-group').removeClass('has-error');
	$('.help-block').empty();
	
	$.ajax({
		url: "<?php echo site_url('event/ajax_edit/')?>/" + id,
		type: "GET",
		dataType: "JSON",
		success: function(data)
		{
			$('[name="id"]').val(data.id);
			$('[name="eventTypeId"]').val(data.id_event_type);
			$('[name="eventName"]').val(data.event_name);
			$('[name="location"]').val(data.location);
			$('[name="dateStart"]').datepicker('update', data.date_start);
			$('[name="dateEnd"]').datepicker('update', data.date_end);
			$('[name="timeStart"]').val(data.time_start);
			$('[name="timeEnd"]').val(data.time_end);
			$('[name="remarks"]').val(data.remarks);
			$('#modal_form').modal('show');
			$('.modal-title').text('Edit Event');
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
		url = "<?php echo site_url('event/ajax_add')?>";
	} else {
		url = "<?php echo site_url('event/ajax_update')?>";
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

function delete_event(id)
{
	if(confirm('Are you sure to delete this data?'))
	{
		$.ajax({
			url: "<?php echo site_url('event/ajax_delete')?>/"+id,
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
				<h3 class="modal-title">Event Form</h3>
			</div>
			<div class="modal-body form">
				<form action="#" id="form" class="form-horizontal">
					<input type="hidden" value="" name="id" />
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Event Type</label>
							<div class="col-md-9">
								<select name="eventTypeId" class="form-control">
									<option value="0">------------Select Event Type------------</option>
									<?php foreach($records as $row) { ?>
									<option value="<?=$row->id?>"><?=$row->appellation?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Event Name</label>
							<div class="col-md-9">
								<input name="eventName" placeholder="Event Name" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Location</label>
							<div class="col-md-9">
								<input name="location" placeholder="Location" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Date Start</label>
							<div class="col-md-9">
								<input name="dateStart" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Date End</label>
							<div class="col-md-9">
								<input name="dateEnd" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Time Start</label>
							<div class="col-md-9">
								<input name="timeStart" placeholder="H:m:s" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Time End</label>
							<div class="col-md-9">
								<input name="timeEnd" placeholder="H:m:s" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Remarks</label>
							<div class="col-md-9">
								<textarea name="remarks" placeholder="Remarks" class="form-control"></textarea>
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