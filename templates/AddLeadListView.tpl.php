<?php
	$this->assign('title','FRANCHISE | Leads');
	$this->assign('nav','leads');

	$this->display('_Header.tpl.php');
?>
<script type='text/javascript' src='custom_js/lead.js'></script>
<div class="fluid-container">


	<!-- underscore template for the collection -->
	<script type="text/template" id="leadCollectionTemplate">
		
	</script>	
	
	<div id="collectionAlert"></div>
	
	<div id="leadCollectionContainer" class="collectionContainer">
	</div>

	
	 <div id="leadModelContainer" class="workplace">
	 	<!-- underscore template for the model -->
	<script type="text/template" id="leadModelTemplate">
		
        	<form onsubmit="return false;">
		<!-- <form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
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
				<div id="stateIdInputContainer" class="control-group">
					<label class="control-label" for="stateId">State Id</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="stateId" placeholder="State Id" value="<%= _.escape(item.get('stateId') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="customerIdInputContainer" class="control-group">
					<label class="control-label" for="customerId">Customer Id</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="customerId" placeholder="Customer Id" value="<%= _.escape(item.get('customerId') || '') %>">
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
				<div id="accountTypeIdInputContainer" class="control-group">
					<label class="control-label" for="accountTypeId">Account Type Id</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="accountTypeId" placeholder="Account Type Id" value="<%= _.escape(item.get('accountTypeId') || '') %>">
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
				<div id="serviceIdInputContainer" class="control-group">
					<label class="control-label" for="serviceId">Service Id</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="serviceId" placeholder="Service Id" value="<%= _.escape(item.get('serviceId') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form> -->


        <div class="row-fluid">           
            <div class="span6">
                <div class="head">
                    <div class="isw-documents"></div>
                    <h1>Contact</h1>
                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span3">
                            First name
                        </div>
                        <div class="span3">
                            <input id="fname" type="text" class="form-control" >
                        </div>
                        <div class="span3">
                            Last name
                        </div>
                        <div class="span3">
                            <input id="lname" type="text" class="form-control" >
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Company name
                        </div>
                        <div class="span9">
                            <input id="branchname" type="text" class="form-control">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Phone
                        </div>
                        <div class="span3">
                            <input id="phone" type="text" class="form-control">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Mobile
                        </div>
                        <div class="span3">
                            <input id="mobile" type="text" class="form-control" >
                            <label>(0412000111)</label>
                        </div>
                        <div class="clear"></div>
                    </div>                    
                    <div class="row-form">
                        <div class="span3">
                            Email
                        </div>
                        <div class="span9">
                            <input id="email" type="text" class="form-control">                           
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
             <div class="span6">
                <div class="head">
                    <div class="isw-documents"></div>
                    <h1>Address</h1>
                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                	<div class="row-form">
                        <div class="span3">
                            Address
                        </div>
                        <div class="span5">
                            <input id="address" type="text" class="form-control" >
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Suburb
                        </div>
                        <div class="span5">
                            <input id="suburb" type="text" class="form-control" >
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Postcode
                        </div>
                        <div class="span5">
                            <input id="postcode" type="text" class="form-control" >
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            State
                        </div>
                        <div class="span5">
                            <select id="state" name="select">
                                <?php
	                        		if(isset($this->stateinfo)){
	                        			foreach ($this->stateinfo as $state) {
	                        				if($state->code == "VIC"){
	                        					echo "<option value='".$state->id."' active>".$state->name."</option>";
	                        				}else{
	                        					echo "<option value='".$state->id."'>".$state->name."</option>";
	                        				}
											
										}
	                        		}
	                        	?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            City
                        </div>
                        <div class="span9">
                            <input id="city" type="text" class="form-control"  value="Melbourne">
                        </div>
                        <div class="clear"></div>
                    </div>  
                     <div class="row-form">
                        <div class="span3">
                            Validate Address
                        </div>
                        <div class="span9">
                            <a class="btn btn-success" href="https://www.google.com.au/maps/" target="_blank">Validate</a>
                        </div>
                        <div class="clear"></div>
                    </div>   
                </div>
            </div>
        </div>
        <?php if($this->CURRENT_USER->RoleId == 4 && $this->CURRENT_USER->RoleId != ""){?>
        	 <div class="dr">
	            <span></span>
	        </div>
        	<div>
        		<div class="row-fluid">
		            <div class="span12">
		                <div class="head">
		                    <div class="isw-documents"></div>
		                    <h1>Service</h1>
		                    <div class="clear"></div>
		                </div>
		                <div class="block-fluid">
		                    <div class="row-form">
		                        <div class="span3">
		                            Service code
		                        </div>
		                        
		                        <div class="span4">
		                        	<select id="service_code" name="select" >
		                        		<option value="0">choose a option...</option>
			                        	<?php
			                        		require_once("php/model/User.php")
			                        	?>     
		                            </select>
		                        </div>
		                        <div class="clear"></div>
		                    </div>
		                </div>
		            </div>
		        </div>
        	</div>
        <?php } ?>
        <div class="dr">
            <span></span>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="head">
                    <div class="isw-documents"></div>
                    <h1>Service</h1>
                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span3">
                            Service code
                        </div>
                        
                        <div class="span4">
                        	<select id="service_code" name="select" >
                        		<option value="0">choose a option...</option>
	                        	<?php
	                        		if(isset($this->serviceinfo)){
	                        			foreach ($this->serviceinfo as $ser) {
											echo "<option value='".$ser->id."'>".$ser->name."</option>";
										}
	                        		}
	                        	?>     
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Price (Inc GST/WAT)
                        </div>
                        <div class="span4">
                            <input id="price" type="text" class="form-control">
                        </div>
                        <div class="clear"></div>
                    </div>
                     <div class="row-form">
                        <div class="span3">
                            Note
                        </div>
                        <div class="span9">
                            <textarea id="note" class="form-control" cols="3"></textarea>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3"></div>
                        <div class="span9">
                            <button  id="saveLeadButton" onclick="submit_addlead();" type="submit" class="btn" type="button">Add Lead</button>
                            <button type="reset" class="btn btn-warning" type="button">Clear</button>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    </script>

</div> <!-- /container -->


<script type="text/javascript">
	$LAB.script("scripts/app/leads.js").wait(function(){
		$(document).ready(function(){
			page.init();
		});
		
		// hack for IE9 which may respond inconsistently with document.ready
		setTimeout(function(){
			if (!page.isInitialized) page.init();
		},1000);
	});
</script>


<?php
	$this->display('_Footer.tpl.php');
?>
