<?php
/** @package AuthExample::Controller */

/** import supporting libraries */
require_once ("AppBaseController.php");
require_once ("UserController.php");
/**
 * DefaultController is the entry point to the application
 *
 * @package AuthExample::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class DefaultController extends AppBaseController {

	/**
	 * Override here for any controller-specific functionality
	 */
	protected function Init() {
		parent::Init();

		// TODO: add controller-wide bootstrap code

		// TODO: if authentiation is required for this entire controller, for example:
		// $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	public function get_user_info() {
		// $package = $this->Phreezer->get("Default",$id);
		// echo $package->Description;
		//echo "test";
	}

	/**
	 * Display the home page for the application
	 */
	public function Home() {
		try {
			$criteria = new UserCriteria();
			
			$user = $this->GetCurrentUser();
			if($user->Id != null){
				$criteria -> Id_Equals = $user->Id;
			}
			$company = $this -> Phreezer -> Query('UserReporter', $criteria);
			$company = $company->ToObjectArray(true, $this->SimpleObjectParams());
			// $this->RenderJSON($company, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		} catch (Exception $ex) {
			$this -> RenderExceptionJSON($ex);
		}
		$this -> Assign("userinfo", $user);
		$this -> Assign("companyinfo", $company);
		$this -> Render();
	}

	/**
	 * Displayed when an invalid route is specified
	 */
	public function Error404() {
		$this -> Render();
	}

	/**
	 * Display a fatal error message
	 */
	public function ErrorFatal() {
		$this -> Render();
	}

	public function ErrorApi404() {
		$this -> RenderErrorJSON('An unknown API endpoint was requested.');
	}

}
?>