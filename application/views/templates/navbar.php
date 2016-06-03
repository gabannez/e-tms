<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>    
	</div>
	<!--<a class="navbar-brand" href="#">Brand</a>-->
	<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav nav-tabs nav-left">
			<li><a href="<?php echo base_url('index.php/user_event/user')?>">Home</a></li>
			<li><a href="<?php echo base_url('index.php/user_event/event')?>">Event</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$name?> <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li>
						<a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
					</li>
					<li>
						<a href="<?php echo base_url('index.php/logout')?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>

<script type="text/javascript">
$(document).ready(function() {
	 $('.nav-tabs a[href="'+location.href+'"]').parents('li').addClass('active');
});
</script>
