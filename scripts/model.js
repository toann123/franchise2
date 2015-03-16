/**
 * backbone model definitions for FRANCHISE
 */

/**
 * Use emulated HTTP if the server doesn't support PUT/DELETE or application/json requests
 */
Backbone.emulateHTTP = false;
Backbone.emulateJSON = false;

var model = {};

/**
 * long polling duration in miliseconds.  (5000 = recommended, 0 = disabled)
 * warning: setting this to a low number will increase server load
 */
model.longPollDuration = 0;

/**
 * whether to refresh the collection immediately after a model is updated
 */
model.reloadCollectionOnModelUpdate = true;

/**
 * Role Backbone Model
 */
model.RoleModel = Backbone.Model.extend({
	urlRoot: 'api/role',
	idAttribute: 'id',
	id: '',
	name: '',
	canAdmin: '',
	canEdit: '',
	canWrite: '',
	canRead: '',
	defaults: {
		'id': null,
		'name': '',
		'canAdmin': '',
		'canEdit': '',
		'canWrite': '',
		'canRead': ''
	}
});

/**
 * Role Backbone Collection
 */
model.RoleCollection = Backbone.Collection.extend({
	url: 'api/roles',
	model: model.RoleModel,

	totalResults: 0,
	totalPages: 0,
	currentPage: 0,
	pageSize: 0,
	orderBy: '',
	orderDesc: false,
	lastResponseText: null,
	collectionHasChanged: true,

	/**
	 * override parse to track changes and handle pagination
	 * if the server call has returned page data
	 */
	parse: function(response, xhr) {

		// check the raw response to determine if collection actually changed
		// note xhr param was removed from backbone 0.99
		var responseText = xhr ? xhr.responseText : JSON.stringify(response);
		this.collectionHasChanged = (this.lastResponseText != responseText);
		this.lastResponseText = responseText;

		var rows;

		if (response.currentPage)
		{
			rows = response.rows;
			this.totalResults = response.totalResults;
			this.totalPages = response.totalPages;
			this.currentPage = response.currentPage;
			this.pageSize = response.pageSize;
			this.orderBy = response.orderBy;
			this.orderDesc = response.orderDesc;
		}
		else
		{
			rows = response;
			this.totalResults = rows.length;
			this.totalPages = 1;
			this.currentPage = 1;
			this.pageSize = this.totalResults;
			this.orderBy = response.orderBy;
			this.orderDesc = response.orderDesc;
		}

		return rows;
	}
});

/**
 * User Backbone Model
 */
model.UserModel = Backbone.Model.extend({
	urlRoot: 'api/user',
	idAttribute: 'id',
	id: '',
	roleId: '',
	roleName: '',
	username: '',
	password: '',
	firstName: '',
	lastName: '',
	defaults: {
		'id': null,
		'roleId': '',
		'roleName': 'Anonymous',
		'username': '',
		'password': '',
		'firstName': '',
		'lastName': ''
	}
});

/**
 * User Backbone Collection
 */
model.UserCollection = Backbone.Collection.extend({
	url: 'api/users',
	model: model.UserModel,

	totalResults: 0,
	totalPages: 0,
	currentPage: 0,
	pageSize: 0,
	orderBy: '',
	orderDesc: false,
	lastResponseText: null,
	collectionHasChanged: true,

	/**
	 * override parse to track changes and handle pagination
	 * if the server call has returned page data
	 */
	parse: function(response, xhr) {

		// check the raw response to determine if collection actually changed
		// note xhr param was removed from backbone 0.99
		var responseText = xhr ? xhr.responseText : JSON.stringify(response);
		this.collectionHasChanged = (this.lastResponseText != responseText);
		this.lastResponseText = responseText;

		var rows;

		if (response.currentPage)
		{
			rows = response.rows;
			this.totalResults = response.totalResults;
			this.totalPages = response.totalPages;
			this.currentPage = response.currentPage;
			this.pageSize = response.pageSize;
			this.orderBy = response.orderBy;
			this.orderDesc = response.orderDesc;
		}
		else
		{
			rows = response;
			this.totalResults = rows.length;
			this.totalPages = 1;
			this.currentPage = 1;
			this.pageSize = this.totalResults;
			this.orderBy = response.orderBy;
			this.orderDesc = response.orderDesc;
		}

		return rows;
	}
});



/**
 * a default sort method for sorting collection items.  this will sort the collection
 * based on the orderBy and orderDesc property that was used on the last fetch call
 * to the server. 
 */
model.AbstractCollection = Backbone.Collection.extend({
	totalResults: 0,
	totalPages: 0,
	currentPage: 0,
	pageSize: 0,
	orderBy: '',
	orderDesc: false,
	lastResponseText: null,
	lastRequestParams: null,
	collectionHasChanged: true,
	
	/**
	 * fetch the collection from the server using the same options and 
	 * parameters as the previous fetch
	 */
	refetch: function() {
		this.fetch({ data: this.lastRequestParams })
	},
	
	/* uncomment to debug fetch event triggers
	fetch: function(options) {
            this.constructor.__super__.fetch.apply(this, arguments);
	},
	// */
	
	/**
	 * client-side sorting baesd on the orderBy and orderDesc parameters that
	 * were used to fetch the data from the server.  Backbone ignores the
	 * order of records coming from the server so we have to sort them ourselves
	 */
	comparator: function(a,b) {
		
		var result = 0;
		var options = this.lastRequestParams;
		
		if (options && options.orderBy) {
			
			// lcase the first letter of the property name
			var propName = options.orderBy.charAt(0).toLowerCase() + options.orderBy.slice(1);
			var aVal = a.get(propName);
			var bVal = b.get(propName);
			
			if (isNaN(aVal) || isNaN(bVal)) {
				// treat comparison as case-insensitive strings
				aVal = aVal ? aVal.toLowerCase() : '';
				bVal = bVal ? bVal.toLowerCase() : '';
			} else {
				// treat comparision as a number
				aVal = Number(aVal);
				bVal = Number(bVal);
			}
			
			if (aVal < bVal) {
				result = options.orderDesc ? 1 : -1;
			} else if (aVal > bVal) {
				result = options.orderDesc ? -1 : 1;
			}
		}
		
		return result;

	},
	/**
	 * override parse to track changes and handle pagination
	 * if the server call has returned page data
	 */
	parse: function(response, options) {

		// the response is already decoded into object form, but it's easier to
		// compary the stringified version.  some earlier versions of backbone did
		// not include the raw response so there is some legacy support here
		var responseText = options && options.xhr ? options.xhr.responseText : JSON.stringify(response);
		this.collectionHasChanged = (this.lastResponseText != responseText);
		this.lastRequestParams = options ? options.data : undefined;
		
		// if the collection has changed then we need to force a re-sort because backbone will
		// only resort the data if a property in the model has changed
		if (this.lastResponseText && this.collectionHasChanged) this.sort({ silent:true });
		
		this.lastResponseText = responseText;
		
		var rows;

		if (response.currentPage) {
			rows = response.rows;
			this.totalResults = response.totalResults;
			this.totalPages = response.totalPages;
			this.currentPage = response.currentPage;
			this.pageSize = response.pageSize;
			this.orderBy = response.orderBy;
			this.orderDesc = response.orderDesc;
		} else {
			rows = response;
			this.totalResults = rows.length;
			this.totalPages = 1;
			this.currentPage = 1;
			this.pageSize = this.totalResults;
			this.orderBy = response.orderBy;
			this.orderDesc = response.orderDesc;
		}

		return rows;
	}
});

/**
 * Account Backbone Model
 */
model.AccountModel = Backbone.Model.extend({
	urlRoot: 'api/account',
	idAttribute: 'id',
	id: '',
	firstname: '',
	lastname: '',
	accountTypeId: '',
	companyId: '',
	email: '',
	phone: '',
	mobile: '',
	address: '',
	suburb: '',
	postcode: '',
	state: '',
	city: '',
	password: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'firstname': '',
		'lastname': '',
		'accountTypeId': '',
		'companyId': '',
		'email': '',
		'phone': '',
		'mobile': '',
		'address': '',
		'suburb': '',
		'postcode': '',
		'state': '',
		'city': '',
		'password': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * Account Backbone Collection
 */
model.AccountCollection = model.AbstractCollection.extend({
	url: 'api/accounts',
	model: model.AccountModel
});

/**
 * AccountMonth Backbone Model
 */
model.AccountMonthModel = Backbone.Model.extend({
	urlRoot: 'api/accountmonth',
	idAttribute: 'id',
	id: '',
	accountId: '',
	baseFeeId: '',
	status: '',
	createdDate: '',
	defaults: {
		'id': null,
		'accountId': '',
		'baseFeeId': '',
		'status': '',
		'createdDate': ''
	}
});

/**
 * AccountMonth Backbone Collection
 */
model.AccountMonthCollection = model.AbstractCollection.extend({
	url: 'api/accountmonths',
	model: model.AccountMonthModel
});

/**
 * AccountType Backbone Model
 */
model.AccountTypeModel = Backbone.Model.extend({
	urlRoot: 'api/accounttype',
	idAttribute: 'id',
	id: '',
	name: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'name': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * AccountType Backbone Collection
 */
model.AccountTypeCollection = model.AbstractCollection.extend({
	url: 'api/accounttypes',
	model: model.AccountTypeModel
});

/**
 * BaseFee Backbone Model
 */
model.BaseFeeModel = Backbone.Model.extend({
	urlRoot: 'api/basefee',
	idAttribute: 'id',
	id: '',
	name: '',
	description: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'name': '',
		'description': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * BaseFee Backbone Collection
 */
model.BaseFeeCollection = model.AbstractCollection.extend({
	url: 'api/basefees',
	model: model.BaseFeeModel
});

/**
 * Company Backbone Model
 */
model.CompanyModel = Backbone.Model.extend({
	urlRoot: 'api/company',
	idAttribute: 'id',
	id: '',
	name: '',
	code: '',
	territory: '',
	region: '',
	start: '',
	phone: '',
	mobile: '',
	email: '',
	address: '',
	suburb: '',
	postcode: '',
	state: '',
	city: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'name': '',
		'code': '',
		'territory': '',
		'region': '',
		'start': new Date(),
		'phone': '',
		'mobile': '',
		'email': '',
		'address': '',
		'suburb': '',
		'postcode': '',
		'state': '',
		'city': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * Company Backbone Collection
 */
model.CompanyCollection = model.AbstractCollection.extend({
	url: 'api/companies',
	model: model.CompanyModel
});

/**
 * Customer Backbone Model
 */
model.CustomerModel = Backbone.Model.extend({
	urlRoot: 'api/customer',
	idAttribute: 'id',
	id: '',
	firstname: '',
	lastname: '',
	accountId: '',
	branchName: '',
	phone: '',
	mobile: '',
	email: '',
	address: '',
	suburb: '',
	postcode: '',
	state: '',
	city: '',
	createdBy: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'firstname': '',
		'lastname': '',
		'accountId': '',
		'branchName': '',
		'phone': '',
		'mobile': '',
		'email': '',
		'address': '',
		'suburb': '',
		'postcode': '',
		'state': '',
		'city': '',
		'createdBy': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * Customer Backbone Collection
 */
model.CustomerCollection = model.AbstractCollection.extend({
	url: 'api/customers',
	model: model.CustomerModel
});

/**
 * Lead Backbone Model
 */
model.LeadModel = Backbone.Model.extend({
	urlRoot: 'api/lead',
	idAttribute: 'id',
	id: '',
	status: '',
	stateId: '',
	customerId: '',
	accountId: '',
	accountTypeId: '',
	createdDate: '',
	updatedDate: '',
	serviceId: '',
	defaults: {
		'id': null,
		'status': '',
		'stateId': '',
		'customerId': '',
		'accountId': '',
		'accountTypeId': '',
		'createdDate': '',
		'updatedDate': '',
		'serviceId': ''
	}
});

/**
 * Lead Backbone Collection
 */
model.LeadCollection = model.AbstractCollection.extend({
	url: 'api/leads',
	model: model.LeadModel
});

/**
 * Post Backbone Model
 */
model.PostModel = Backbone.Model.extend({
	urlRoot: 'api/post',
	idAttribute: 'id',
	id: '',
	name: '',
	code: '',
	stateId: '',
	accountId: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'name': '',
		'code': '',
		'stateId': '',
		'accountId': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * Post Backbone Collection
 */
model.PostCollection = model.AbstractCollection.extend({
	url: 'api/posts',
	model: model.PostModel
});

/**
 * Receive Backbone Model
 */
model.ReceiveModel = Backbone.Model.extend({
	urlRoot: 'api/receive',
	idAttribute: 'id',
	id: '',
	accountId: '',
	customerId: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'accountId': '',
		'customerId': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * Receive Backbone Collection
 */
model.ReceiveCollection = model.AbstractCollection.extend({
	url: 'api/receives',
	model: model.ReceiveModel
});

/**
 * Schedule Backbone Model
 */
model.ScheduleModel = Backbone.Model.extend({
	urlRoot: 'api/schedule',
	idAttribute: 'id',
	id: '',
	workId: '',
	accountId: '',
	startdate: '',
	enddate: '',
	maximum: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'workId': '',
		'accountId': '',
		'startdate': new Date(),
		'enddate': new Date(),
		'maximum': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * Schedule Backbone Collection
 */
model.ScheduleCollection = model.AbstractCollection.extend({
	url: 'api/schedules',
	model: model.ScheduleModel
});

/**
 * Service Backbone Model
 */
model.ServiceModel = Backbone.Model.extend({
	urlRoot: 'api/service',
	idAttribute: 'id',
	id: '',
	name: '',
	code: '',
	description: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'name': '',
		'code': '',
		'description': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * Service Backbone Collection
 */
model.ServiceCollection = model.AbstractCollection.extend({
	url: 'api/services',
	model: model.ServiceModel
});

/**
 * State Backbone Model
 */
model.StateModel = Backbone.Model.extend({
	urlRoot: 'api/state',
	idAttribute: 'id',
	id: '',
	name: '',
	code: '',
	defaults: {
		'id': null,
		'name': '',
		'code': ''
	}
});

/**
 * State Backbone Collection
 */
model.StateCollection = model.AbstractCollection.extend({
	url: 'api/states',
	model: model.StateModel
});

/**
 * Support Backbone Model
 */
model.SupportModel = Backbone.Model.extend({
	urlRoot: 'api/support',
	idAttribute: 'id',
	id: '',
	position: '',
	firstname: '',
	lastname: '',
	phone: '',
	mobile: '',
	email: '',
	address: '',
	postcode: '',
	state: '',
	city: '',
	companyId: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'position': '',
		'firstname': '',
		'lastname': '',
		'phone': '',
		'mobile': '',
		'email': '',
		'address': '',
		'postcode': '',
		'state': '',
		'city': '',
		'companyId': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * Support Backbone Collection
 */
model.SupportCollection = model.AbstractCollection.extend({
	url: 'api/supports',
	model: model.SupportModel
});

/**
 * User Backbone Model
 */
model.UserModel = Backbone.Model.extend({
	urlRoot: 'api/user',
	idAttribute: 'id',
	id: '',
	firstname: '',
	lastname: '',
	email: '',
	phone: '',
	mobile: '',
	status: '',
	defaults: {
		'id': null,
		'firstname': '',
		'lastname': '',
		'email': '',
		'phone': '',
		'mobile': '',
		'status': ''
	}
});

/**
 * User Backbone Collection
 */
model.UserCollection = model.AbstractCollection.extend({
	url: 'api/users',
	model: model.UserModel
});

/**
 * Work Backbone Model
 */
model.WorkModel = Backbone.Model.extend({
	urlRoot: 'api/work',
	idAttribute: 'id',
	id: '',
	name: '',
	description: '',
	createdDate: '',
	updatedDate: '',
	status: '',
	defaults: {
		'id': null,
		'name': '',
		'description': '',
		'createdDate': '',
		'updatedDate': '',
		'status': ''
	}
});

/**
 * Work Backbone Collection
 */
model.WorkCollection = model.AbstractCollection.extend({
	url: 'api/works',
	model: model.WorkModel
});

