<?php
/** @package    FRANCHISE::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Company.php");

/**
 * CompanyController is the controller class for the Company object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package FRANCHISE::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class CompanyController extends AppBaseController
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
	 * Displays a list view of Company objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Company records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new CompanyCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Name,Code,Territory,Region,Start,Phone,Mobile,Email,Address,Suburb,Postcode,State,City,CreatedDate,UpdatedDate,Status'
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

				$companies = $this->Phreezer->Query('Company',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $companies->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $companies->TotalResults;
				$output->totalPages = $companies->TotalPages;
				$output->pageSize = $companies->PageSize;
				$output->currentPage = $companies->CurrentPage;
			}
			else
			{
				// return all results
				$companies = $this->Phreezer->Query('Company',$criteria);
				$output->rows = $companies->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single Company record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$company = $this->Phreezer->Get('Company',$pk);
			$this->RenderJSON($company, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Company record and render response as JSON
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

			$company = new Company($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $company->Id = $this->SafeGetVal($json, 'id');

			$company->Name = $this->SafeGetVal($json, 'name');
			$company->Code = $this->SafeGetVal($json, 'code');
			$company->Territory = $this->SafeGetVal($json, 'territory');
			$company->Region = $this->SafeGetVal($json, 'region');
			$company->Start = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'start')));
			$company->Phone = $this->SafeGetVal($json, 'phone');
			$company->Mobile = $this->SafeGetVal($json, 'mobile');
			$company->Email = $this->SafeGetVal($json, 'email');
			$company->Address = $this->SafeGetVal($json, 'address');
			$company->Suburb = $this->SafeGetVal($json, 'suburb');
			$company->Postcode = $this->SafeGetVal($json, 'postcode');
			$company->State = $this->SafeGetVal($json, 'state');
			$company->City = $this->SafeGetVal($json, 'city');
			$company->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate')));
			$company->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate')));
			$company->Status = $this->SafeGetVal($json, 'status');

			$company->Validate();
			$errors = $company->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$company->Save();
				$this->RenderJSON($company, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Company record and render response as JSON
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
			$company = $this->Phreezer->Get('Company',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $company->Id = $this->SafeGetVal($json, 'id', $company->Id);

			$company->Name = $this->SafeGetVal($json, 'name', $company->Name);
			$company->Code = $this->SafeGetVal($json, 'code', $company->Code);
			$company->Territory = $this->SafeGetVal($json, 'territory', $company->Territory);
			$company->Region = $this->SafeGetVal($json, 'region', $company->Region);
			$company->Start = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'start', $company->Start)));
			$company->Phone = $this->SafeGetVal($json, 'phone', $company->Phone);
			$company->Mobile = $this->SafeGetVal($json, 'mobile', $company->Mobile);
			$company->Email = $this->SafeGetVal($json, 'email', $company->Email);
			$company->Address = $this->SafeGetVal($json, 'address', $company->Address);
			$company->Suburb = $this->SafeGetVal($json, 'suburb', $company->Suburb);
			$company->Postcode = $this->SafeGetVal($json, 'postcode', $company->Postcode);
			$company->State = $this->SafeGetVal($json, 'state', $company->State);
			$company->City = $this->SafeGetVal($json, 'city', $company->City);
			$company->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate', $company->CreatedDate)));
			$company->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate', $company->UpdatedDate)));
			$company->Status = $this->SafeGetVal($json, 'status', $company->Status);

			$company->Validate();
			$errors = $company->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$company->Save();
				$this->RenderJSON($company, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Company record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$company = $this->Phreezer->Get('Company',$pk);

			$company->Delete();

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
