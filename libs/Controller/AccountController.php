<?php
/** @package    FRANCHISE::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Account.php");

/**
 * AccountController is the controller class for the Account object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package FRANCHISE::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class AccountController extends AppBaseController
{

	/**
	 * Override here for any controller-specific functionality
	 *
	 * @inheritdocs
	 */
	protected function Init()
	{
		parent::Init();

		// TODO: add controller-wide bootstrap code
		
		// TODO: if authentiation is required for this entire controller, for example:
		// $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	/**
	 * Displays a list view of Account objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Account records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new AccountCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Firstname,Lastname,AccountTypeId,CompanyId,Email,Phone,Mobile,Address,Suburb,Postcode,State,City,Password,CreatedDate,UpdatedDate,Status'
				, '%'.$filter.'%')
			);

			// TODO: this is generic query filtering based only on criteria properties
			foreach (array_keys($_REQUEST) as $prop)
			{
				$prop_normal = ucfirst($prop);
				$prop_equals = $prop_normal.'_Equals';

				if (property_exists($criteria, $prop_normal))
				{
					$criteria->$prop_normal = RequestUtil::Get($prop);
				}
				elseif (property_exists($criteria, $prop_equals))
				{
					// this is a convenience so that the _Equals suffix is not needed
					$criteria->$prop_equals = RequestUtil::Get($prop);
				}
			}

			$output = new stdClass();

			// if a sort order was specified then specify in the criteria
 			$output->orderBy = RequestUtil::Get('orderBy');
 			$output->orderDesc = RequestUtil::Get('orderDesc') != '';
 			if ($output->orderBy) $criteria->SetOrder($output->orderBy, $output->orderDesc);

			$page = RequestUtil::Get('page');

			if ($page != '')
			{
				// if page is specified, use this instead (at the expense of one extra count query)
				$pagesize = $this->GetDefaultPageSize();

				$accounts = $this->Phreezer->Query('Account',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $accounts->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $accounts->TotalResults;
				$output->totalPages = $accounts->TotalPages;
				$output->pageSize = $accounts->PageSize;
				$output->currentPage = $accounts->CurrentPage;
			}
			else
			{
				// return all results
				$accounts = $this->Phreezer->Query('Account',$criteria);
				$output->rows = $accounts->ToObjectArray(true, $this->SimpleObjectParams());
				$output->totalResults = count($output->rows);
				$output->totalPages = 1;
				$output->pageSize = $output->totalResults;
				$output->currentPage = 1;
			}


			$this->RenderJSON($output, $this->JSONPCallback());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method retrieves a single Account record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$account = $this->Phreezer->Get('Account',$pk);
			$this->RenderJSON($account, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Account record and render response as JSON
	 */
	public function Create()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$account = new Account($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $account->Id = $this->SafeGetVal($json, 'id');

			$account->Firstname = $this->SafeGetVal($json, 'firstname');
			$account->Lastname = $this->SafeGetVal($json, 'lastname');
			$account->AccountTypeId = $this->SafeGetVal($json, 'accountTypeId');
			$account->CompanyId = $this->SafeGetVal($json, 'companyId');
			$account->Email = $this->SafeGetVal($json, 'email');
			$account->Phone = $this->SafeGetVal($json, 'phone');
			$account->Mobile = $this->SafeGetVal($json, 'mobile');
			$account->Address = $this->SafeGetVal($json, 'address');
			$account->Suburb = $this->SafeGetVal($json, 'suburb');
			$account->Postcode = $this->SafeGetVal($json, 'postcode');
			$account->State = $this->SafeGetVal($json, 'state');
			$account->City = $this->SafeGetVal($json, 'city');
			$account->Password = $this->SafeGetVal($json, 'password');
			$account->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate')));
			$account->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate')));
			$account->Status = $this->SafeGetVal($json, 'status');

			$account->Validate();
			$errors = $account->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$account->Save();
				$this->RenderJSON($account, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Account record and render response as JSON
	 */
	public function Update()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$pk = $this->GetRouter()->GetUrlParam('id');
			$account = $this->Phreezer->Get('Account',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $account->Id = $this->SafeGetVal($json, 'id', $account->Id);

			$account->Firstname = $this->SafeGetVal($json, 'firstname', $account->Firstname);
			$account->Lastname = $this->SafeGetVal($json, 'lastname', $account->Lastname);
			$account->AccountTypeId = $this->SafeGetVal($json, 'accountTypeId', $account->AccountTypeId);
			$account->CompanyId = $this->SafeGetVal($json, 'companyId', $account->CompanyId);
			$account->Email = $this->SafeGetVal($json, 'email', $account->Email);
			$account->Phone = $this->SafeGetVal($json, 'phone', $account->Phone);
			$account->Mobile = $this->SafeGetVal($json, 'mobile', $account->Mobile);
			$account->Address = $this->SafeGetVal($json, 'address', $account->Address);
			$account->Suburb = $this->SafeGetVal($json, 'suburb', $account->Suburb);
			$account->Postcode = $this->SafeGetVal($json, 'postcode', $account->Postcode);
			$account->State = $this->SafeGetVal($json, 'state', $account->State);
			$account->City = $this->SafeGetVal($json, 'city', $account->City);
			$account->Password = $this->SafeGetVal($json, 'password', $account->Password);
			$account->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate', $account->CreatedDate)));
			$account->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate', $account->UpdatedDate)));
			$account->Status = $this->SafeGetVal($json, 'status', $account->Status);

			$account->Validate();
			$errors = $account->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$account->Save();
				$this->RenderJSON($account, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Account record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$account = $this->Phreezer->Get('Account',$pk);

			$account->Delete();

			$output = new stdClass();

			$this->RenderJSON($output, $this->JSONPCallback());

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}
}

?>
