	<br />
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
				<th style="width:50px;">Action</th>
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
var count;

$(document).ready(function() {
	
	table = $('#table').DataTable({
		
		"processing": true,
		"serverSide": true,
		"order": [],
		
		"ajax": {
			"url": "<?php echo site_url('user_event/ajax_list_event')?>",
			"type": "POST"
		},
		
		"columnDefs": [
		{
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});
	
	count = $('[name="count"]').val();
	if(count >= 3) {
		
	}
});

function apply_event(id)
{
	save_method = 'add';
	$('#form')[0].reset();
	$('.form-group').removeClass('has-error');
	$('.help-block').empty();
	
	$.ajax({
		url: "<?php echo site_url('user_event/ajax_edit_event/')?>/" + id,
		type: "GET",
		dataType: "JSON",
		success: function(data)
		{
			$('[name="eventname"]').val(data.event_name);
			$('[name="id_event"]').val(data.id);
			$('#modal_form').modal('show');
			$('.modal-title').text('Apply Event');
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
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Event Name</label>
							<div class="col-md-9">
								<input name="eventname" class="form-control" type="text" value="" readonly>
								<input type="hidden" value="" name="id_event" />
								<input name="id_user" type="hidden" value="<?=$user->id?>">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="text-info col-md-12"><center>Are you sure you want to apply?</center></label>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnSave" onClick="save()" class="btn btn-primary">Apply</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
</body>
</html>