<?php
	$this->assign('title','FRANCHISE | Companies');
	$this->assign('nav','companies');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/companies.js").wait(function(){
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
	<i class="icon-th-list"></i> Companies
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="companyCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Name">Name<% if (page.orderBy == 'Name') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Code">Code<% if (page.orderBy == 'Code') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Territory">Territory<% if (page.orderBy == 'Territory') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Region">Region<% if (page.orderBy == 'Region') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Start">Start<% if (page.orderBy == 'Start') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Phone">Phone<% if (page.orderBy == 'Phone') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Mobile">Mobile<% if (page.orderBy == 'Mobile') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Email">Email<% if (page.orderBy == 'Email') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Address">Address<% if (page.orderBy == 'Address') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Suburb">Suburb<% if (page.orderBy == 'Suburb') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Postcode">Postcode<% if (page.orderBy == 'Postcode') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_State">State<% if (page.orderBy == 'State') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_City">City<% if (page.orderBy == 'City') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
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
				<td><%= _.escape(item.get('name') || '') %></td>
				<td><%= _.escape(item.get('code') || '') %></td>
				<td><%= _.escape(item.get('territory') || '') %></td>
				<td><%= _.escape(item.get('region') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%if (item.get('start')) { %><%= _date(app.parseDate(item.get('start'))).format('MMM D, YYYY h:mm A') %><% } else { %>NULL<% } %></td>
				<td><%= _.escape(item.get('phone') || '') %></td>
				<td><%= _.escape(item.get('mobile') || '') %></td>
				<td><%= _.escape(item.get('email') || '') %></td>
				<td><%= _.escape(item.get('address') || '') %></td>
				<td><%= _.escape(item.get('suburb') || '') %></td>
				<td><%= _.escape(item.get('postcode') || '') %></td>
				<td><%= _.escape(item.get('state') || '') %></td>
				<td><%= _.escape(item.get('city') || '') %></td>
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
	<script type="text/template" id="companyModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="nameInputContainer" class="control-group">
					<label class="control-label" for="name">Name</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="name" placeholder="Name" value="<%= _.escape(item.get('name') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="codeInputContainer" class="control-group">
					<label class="control-label" for="code">Code</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="code" placeholder="Code" value="<%= _.escape(item.get('code') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="territoryInputContainer" class="control-group">
					<label class="control-label" for="territory">Territory</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="territory" placeholder="Territory" value="<%= _.escape(item.get('territory') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="regionInputContainer" class="control-group">
					<label class="control-label" for="region">Region</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="region" placeholder="Region" value="<%= _.escape(item.get('region') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="startInputContainer" class="control-group">
					<label class="control-label" for="start">Start</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="start" type="text" value="<%= _date(app.parseDate(item.get('start'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<div class="input-append bootstrap-timepicker-component">
							<input id="start-time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('start'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="phoneInputContainer" class="control-group">
					<label class="control-label" for="phone">Phone</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="phone" placeholder="Phone" value="<%= _.escape(item.get('phone') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="mobileInputContainer" class="control-group">
					<label class="control-label" for="mobile">Mobile</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="mobile" placeholder="Mobile" value="<%= _.escape(item.get('mobile') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="emailInputContainer" class="control-group">
					<label class="control-label" for="email">Email</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="email" placeholder="Email" value="<%= _.escape(item.get('email') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="addressInputContainer" class="control-group">
					<label class="control-label" for="address">Address</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="address" placeholder="Address" value="<%= _.escape(item.get('address') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="suburbInputContainer" class="control-group">
					<label class="control-label" for="suburb">Suburb</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="suburb" placeholder="Suburb" value="<%= _.escape(item.get('suburb') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="postcodeInputContainer" class="control-group">
					<label class="control-label" for="postcode">Postcode</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="postcode" placeholder="Postcode" value="<%= _.escape(item.get('postcode') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="stateInputContainer" class="control-group">
					<label class="control-label" for="state">State</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="state" placeholder="State" value="<%= _.escape(item.get('state') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="cityInputContainer" class="control-group">
					<label class="control-label" for="city">City</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="city" placeholder="City" value="<%= _.escape(item.get('city') || '') %>">
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
		<form id="deleteCompanyButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteCompanyButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Company</button>
						<span id="confirmDeleteCompanyContainer" class="hide">
							<button id="cancelDeleteCompanyButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteCompanyButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal fade" id="companyDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Company
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="companyModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveCompanyButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="companyCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newCompanyButton" class="btn btn-primary">Add Company</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
