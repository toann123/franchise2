<?php
/** @package    FRANCHISE::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/AccountType.php");

/**
 * AccountTypeController is the controller class for the AccountType object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package FRANCHISE::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class AccountTypeController extends AppBaseController
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
	 * Displays a list view of AccountType objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for AccountType records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new AccountTypeCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Name,CreatedDate,UpdatedDate,Status'
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

				$accounttypes = $this->Phreezer->Query('AccountType',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $accounttypes->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $accounttypes->TotalResults;
				$output->totalPages = $accounttypes->TotalPages;
				$output->pageSize = $accounttypes->PageSize;
				$output->currentPage = $accounttypes->CurrentPage;
			}
			else
			{
				// return all results
				$accounttypes = $this->Phreezer->Query('AccountType',$criteria);
				$output->rows = $accounttypes->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single AccountType record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$accounttype = $this->Phreezer->Get('AccountType',$pk);
			$this->RenderJSON($accounttype, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new AccountType record and render response as JSON
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

			$accounttype = new AccountType($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $accounttype->Id = $this->SafeGetVal($json, 'id');

			$accounttype->Name = $this->SafeGetVal($json, 'name');
			$accounttype->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate')));
			$accounttype->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate')));
			$accounttype->Status = $this->SafeGetVal($json, 'status');

			$accounttype->Validate();
			$errors = $accounttype->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$accounttype->Save();
				$this->RenderJSON($accounttype, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing AccountType record and render response as JSON
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
			$accounttype = $this->Phreezer->Get('AccountType',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $accounttype->Id = $this->SafeGetVal($json, 'id', $accounttype->Id);

			$accounttype->Name = $this->SafeGetVal($json, 'name', $accounttype->Name);
			$accounttype->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate', $accounttype->CreatedDate)));
			$accounttype->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate', $accounttype->UpdatedDate)));
			$accounttype->Status = $this->SafeGetVal($json, 'status', $accounttype->Status);

			$accounttype->Validate();
			$errors = $accounttype->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$accounttype->Save();
				$this->RenderJSON($accounttype, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing AccountType record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$accounttype = $this->Phreezer->Get('AccountType',$pk);

			$accounttype->Delete();

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
