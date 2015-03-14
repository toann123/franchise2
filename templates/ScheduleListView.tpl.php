<?php
	$this->assign('title','FRANCHISE | Schedules');
	$this->assign('nav','schedules');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/schedules.js").wait(function(){
		$(document).ready(function(){
			page.init();
		});
		
		// hack for IE9 which may respond inconsistently with document.ready
		setTimeout(function(){
			if (!page.isInitialized) page.init();
		},1000);
	});
</script>

<div class="container">

<h1>
	<i class="icon-th-list"></i> Schedules
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="scheduleCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_WorkId">Work Id<% if (page.orderBy == 'WorkId') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_AccountId">Account Id<% if (page.orderBy == 'AccountId') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Startdate">Startdate<% if (page.orderBy == 'Startdate') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Enddate">Enddate<% if (page.orderBy == 'Enddate') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Maximum">Maximum<% if (page.orderBy == 'Maximum') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_CreatedDate">Created Date<% if (page.orderBy == 'CreatedDate') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_UpdatedDate">Updated Date<% if (page.orderBy == 'UpdatedDate') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Status">Status<% if (page.orderBy == 'Status') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('workId') || '') %></td>
				<td><%= _.escape(item.get('accountId') || '') %></td>
				<td><%if (item.get('startdate')) { %><%= _date(app.parseDate(item.get('startdate'))).format('MMM D, YYYY h:mm A') %><% } else { %>NULL<% } %></td>
				<td><%if (item.get('enddate')) { %><%= _date(app.parseDate(item.get('enddate'))).format('MMM D, YYYY h:mm A') %><% } else { %>NULL<% } %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('maximum') || '') %></td>
				<td><%if (item.get('createdDate')) { %><%= _date(app.parseDate(item.get('createdDate'))).format('MMM D, YYYY h:mm A') %><% } else { %>NULL<% } %></td>
				<td><%if (item.get('updatedDate')) { %><%= _date(app.parseDate(item.get('updatedDate'))).format('MMM D, YYYY h:mm A') %><% } else { %>NULL<% } %></td>
				<td><%= _.escape(item.get('status') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="scheduleModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="workIdInputContainer" class="control-group">
					<label class="control-label" for="workId">Work Id</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="workId" placeholder="Work Id" value="<%= _.escape(item.get('workId') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="accountIdInputContainer" class="control-group">
					<label class="control-label" for="accountId">Account Id</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="accountId" placeholder="Account Id" value="<%= _.escape(item.get('accountId') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="startdateInputContainer" class="control-group">
					<label class="control-label" for="startdate">Startdate</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="startdate" type="text" value="<%= _date(app.parseDate(item.get('startdate'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<div class="input-append bootstrap-timepicker-component">
							<input id="startdate-time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('startdate'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="enddateInputContainer" class="control-group">
					<label class="control-label" for="enddate">Enddate</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="enddate" type="text" value="<%= _date(app.parseDate(item.get('enddate'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<div class="input-append bootstrap-timepicker-component">
							<input id="enddate-time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('enddate'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="maximumInputContainer" class="control-group">
					<label class="control-label" for="maximum">Maximum</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="maximum" placeholder="Maximum" value="<%= _.escape(item.get('maximum') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="createdDateInputContainer" class="control-group">
					<label class="control-label" for="createdDate">Created Date</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="createdDate" type="text" value="<%= _date(app.parseDate(item.get('createdDate'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<div class="input-append bootstrap-timepicker-component">
							<input id="createdDate-time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('createdDate'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="updatedDateInputContainer" class="control-group">
					<label class="control-label" for="updatedDate">Updated Date</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="updatedDate" type="text" value="<%= _date(app.parseDate(item.get('updatedDate'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<div class="input-append bootstrap-timepicker-component">
							<input id="updatedDate-time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('updatedDate'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="statusInputContainer" class="control-group">
					<label class="control-label" for="status">Status</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="status" placeholder="Status" value="<%= _.escape(item.get('status') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteScheduleButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteScheduleButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Schedule</button>
						<span id="confirmDeleteScheduleContainer" class="hide">
							<button id="cancelDeleteScheduleButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteScheduleButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="scheduleDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Schedule
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="scheduleModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveScheduleButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="scheduleCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newScheduleButton" class="btn btn-primary">Add Schedule</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
