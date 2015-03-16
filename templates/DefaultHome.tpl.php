@@ -0,0 +1,317 @@
<?php
	$this->assign('title','FRANCHISE | Home');
	$this->assign('nav','home');

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

<div class="fluid-container">


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

	<div id="collectionAlert"></div>

	 <div class="workplace">
        <div class="row-fluid">
            <div class="span6">
                <div class="head">
                    <div class="isw-documents"></div>
                    <h1>Your Franchise</h1>
                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span3">
                            Code
                        </div>
                        <div class="span9">
                            TN6
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Territory
                        </div>
                        <div class="span9">
                            Jim's Cleaning
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Region
                        </div>
                        <div class="span9">
                            Jim's Cleaning
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Started
                        </div>
                        <div class="span9">
                            21-02-2015
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Status
                        </div>
                        <div class="span9">
                            OK
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="head">
                    <div class="isw-documents"></div>
                    <h1>Your Details</h1>
                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span3">
                            Name
                        </div>
                        <div class="span9">
                            Mr Michael Nguyen
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Mobile
                        </div>
                        <div class="span9">
                            04500336606
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Email
                        </div>
                        <div class="span9">
                            michale.nguyen@jimcleaning.net.au
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Address
                        </div>
                        <div class="span9">
                            39 Fisher St 3012 VIC
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3"></div>
                        <div class="span9"></div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dr">
            <span></span>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="head">
                    <div class="isw-documents"></div>
                    <h1>Contacts at Jim</h1>
                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span3">
                            Franchisor
                        </div>
                        <div class="span9">
                            Martin McAulife - 0418 552 535 <br>
                            marty@jimcleaning.net.au
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div id="supportCollectionContainer" class="row-form collectionContainer">
                    	<script type="text/template" id="supportCollectionTemplate">
                    	<% items.each(function(item) { %>
                    	<div class="span3">
                            Support
                        </div>
                        <div class="span9">
                            <%= _.escape(item.get('firstname') || '') %> <%= _.escape(item.get('lastname') || '') %> - <%= _.escape(item.get('mobile') || '') %> <br>
                            <%= _.escape(item.get('email') || '') %>
                       
                        </div>
                        <% }); %> 
                        <div class="clear"></div>                 
                        </script>  
                    </div>                             
                </div>
            </div>
        </div>
        <div class="dr">
            <span></span>
        </div>
    </div>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
