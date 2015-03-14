<?php
	$this->assign('title','FRANCHISE | Users');
	$this->assign('nav','users');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/users.js").wait(function(){
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
	<i class="icon-th-list"></i> Users
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="userCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Firstname">Firstname<% if (page.orderBy == 'Firstname') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Lastname">Lastname<% if (page.orderBy == 'Lastname') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Email">Email<% if (page.orderBy == 'Email') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Phone">Phone<% if (page.orderBy == 'Phone') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Mobile">Mobile<% if (page.orderBy == 'Mobile') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Status">Status<% if (page.orderBy == 'Status') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('firstname') || '') %></td>
				<td><%= _.escape(item.get('lastname') || '') %></td>
				<td><%= _.escape(item.get('email') || '') %></td>
				<td><%= _.escape(item.get('phone') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('mobile') || '') %></td>
				<td><%= _.escape(item.get('status') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="userModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
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
				<div id="emailInputContainer" class="control-group">
					<label class="control-label" for="email">Email</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="email" placeholder="Email" value="<%= _.escape(item.get('email') || '') %>">
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
		<form id="deleteUserButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteUserButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete User</button>
						<span id="confirmDeleteUserContainer" class="hide">
							<button id="cancelDeleteUserButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteUserButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="userDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit User
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="userModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveUserButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="userCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newUserButton" class="btn btn-primary">Add User</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
