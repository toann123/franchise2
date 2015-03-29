<?php
	$this->assign('title','FRANCHISE | Supports');
	$this->assign('nav','supports');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/supports.js").wait(function(){
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
	<i class="icon-th-list"></i> Supports
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="supportCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Position">Position<% if (page.orderBy == 'Position') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Firstname">Firstname<% if (page.orderBy == 'Firstname') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Lastname">Lastname<% if (page.orderBy == 'Lastname') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Phone">Phone<% if (page.orderBy == 'Phone') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Mobile">Mobile<% if (page.orderBy == 'Mobile') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Email">Email<% if (page.orderBy == 'Email') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Address">Address<% if (page.orderBy == 'Address') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Postcode">Postcode<% if (page.orderBy == 'Postcode') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_State">State<% if (page.orderBy == 'State') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_City">City<% if (page.orderBy == 'City') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_CompanyId">Company Id<% if (page.orderBy == 'CompanyId') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
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
				<td><%= _.escape(item.get('position') || '') %></td>
				<td><%= _.escape(item.get('firstname') || '') %></td>
				<td><%= _.escape(item.get('lastname') || '') %></td>
				<td><%= _.escape(item.get('phone') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('mobile') || '') %></td>
				<td><%= _.escape(item.get('email') || '') %></td>
				<td><%= _.escape(item.get('address') || '') %></td>
				<td><%= _.escape(item.get('postcode') || '') %></td>
				<td><%= _.escape(item.get('state') || '') %></td>
				<td><%= _.escape(item.get('city') || '') %></td>
				<td><%= _.escape(item.get('companyId') || '') %></td>
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
	<script type="text/template" id="supportModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="positionInputContainer" class="control-group">
					<label class="control-label" for="position">Position</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="position" placeholder="Position" value="<%= _.escape(item.get('position') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="firstnameInputContainer" class="control-group">
					<label class="control-label" for="firstname">Firstname</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="firstname" placeholder="Firstname" value="<%= _.escape(item.get('firstname') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="lastnameInputContainer" class="control-group">
					<label class="control-label" for="lastname">Lastname</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="lastname" placeholder="Lastname" value="<%= _.escape(item.get('lastname') || '') %>">
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
				<div id="companyIdInputContainer" class="control-group">
					<label class="control-label" for="companyId">Company Id</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="companyId" placeholder="Company Id" value="<%= _.escape(item.get('companyId') || '') %>">
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
		<form id="deleteSupportButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteSupportButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Support</button>
						<span id="confirmDeleteSupportContainer" class="hide">
							<button id="cancelDeleteSupportButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteSupportButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal fade" id="supportDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Support
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="supportModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveSupportButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="supportCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newSupportButton" class="btn btn-primary">Add Support</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
