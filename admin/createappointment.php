

<style type="text/css">
	.container-fluid {
		width: 1000px;
		height: 580px;
		max-width: 100%;
		margin: 20px auto;
		border-radius: 5px;
		background-color: #fff;
	}
	.calendar {
		width: 550px;
		height: auto;
		max-width: 100%;
		margin: 0 auto;
		background-color: #fff;
		padding: 5px;
		border-radius: 5px;

	}
	.panel-date {
		width: 600px;
		height: 430px;
		max-width: 100%;
		background-color: #fff;
		border-radius: 5px;
		padding: 5px 10px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		text-align: center;
		display: inline-block;
		vertical-align: top;
		/*margin: 20px 10px 0 100px;*/
		transform: translate(30%, 5%);
	}
	.panel-time {
		width: 200px;
		background-color: #fff;
		border-radius: 5px;
		padding: 5px 10px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		text-align: center;
		display: inline-block;
		vertical-align: top;
		margin: 30px auto;
	}
	.time-select {
		width: 150px;
		padding: 5px 0;
		font-size: 1.2em;
		background-color: rgb(153, 193, 60);
		color: #fff;
		border: thin solid #fff;
		border-radius: 5px;
		margin: 5px 0 15px 0;
		cursor: pointer;
	}
	.time-select:hover {
		background-color: #5db6d3;
	}
	.time-select:active {
		background-color: #094966;
	}
	.time-select:disabled {
		background-color: #ccc;
		color: #bbb;
		cursor: unset;
	}
	.header {
		font-size: 2em;
		font-weight: bold;
		color: #28789f;
		text-align: center;
		padding-top: 20px;
		border-bottom: 1px solid #eee;
	}
	.btn-link {
		background-color: #28789f;
		color: #fff;
		text-decoration: none;
		padding: 10px 6px;
		border-radius: 5px;
	}
	.btn-link:hover {
		background-color: #5db6d3;
	}
	.goBack {
		float: right;
		color: tomato;
	}
	.goBack:hover {
		color: #E74C3C;
		cursor: pointer;
	}
</style>
<div class="container-fluid">
	<div class="header"><i class="la la-calendar-plus-o"></i> Book Appointments</div>
	<div class="panel-date">
		<span class="fa fa-close goBack" title="Close" onclick="router('appointments')"></span>
		<div class="lead">Pick a Date and Time</div>
		<div>
			<?php $year = date('Y'); #get current Year ?>
			<select class="form-input" name="year" id="year" onchange="return router('getmonths');">
				<?php for($i=$year; $i <= $year+1; $i++) : ?>
				<option><?php echo $i; ?></option>
				<?php endfor; ?>
			</select>
			<span><a href="javascript:router('getmonths');" class="btn-link"><i class="fa fa-calendar"></i> Change date</a></span>
		</div>
		<div class="calendar">
			<!-- calendat data will be injected here by Javascript -->
		</div>
	</div>
</div>