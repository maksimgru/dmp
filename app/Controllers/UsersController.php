<?php

namespace Controllers;

// use Controllers\Controller;
use Core\Helpers;

/**
 * This is Description of Users class
 *
 */
class UsersController extends Controller
{
    protected $userModel;

    /**
     * Description:
     *
     */
    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
    }

    /**
     * The default controller method
     *
     * @return void
     *
     */
    public function indexAction()
    {
        $this->tableAction();
    }

    /**
     * The controller method
     *
     * @param string $action The name of action: "orderby".
     * @param string $orderby The column name for which ordering is required.
     * @param string $order The direction of ordering "asc", "desc".
     *
     * @return void
     *
     */
    public function tableAction($action = 'orderby', $orderby = 'id', $order = 'asc')
    {
        $columnsMeta = $this->userModel->getColumnsMeta();
        $usersRaces = $this->userModel->getUsersRacesDefault();
        $checkedData = $this->userModel->validateAccessTableForm($_POST);

        $args = [];
        $args['action'] = $action;
        $args['orderby'] = $orderby;
        $args['order'] = $order;
        $args['filterby'] = $_GET;

        // Get Users and sorting args
        $data = $this->userModel->getUsers($args);

        $this->view('users/table', [
            'users' => $data['users'],
            'usersRaces' => $usersRaces,
            'columnsMeta' => $columnsMeta,
            'filterbyRace' => $data['args']['filterby']['race'],
            'filterbyMincrimes' => $data['args']['filterby']['mincrimes'],
            'filterbyUnpunished' => $data['args']['filterby']['unpunished'],
            'isValidForm' => $checkedData['isValidForm'],
            'isAccessTable' => $checkedData['isAccessTable'],
            'errorMessage' => implode('<br>', $checkedData['errorMessage']),
            'formData' => $checkedData['formData'],
            'formErrors' => $checkedData['formErrors'],
        ]);
    }

    /**
     * The controller method
     *
     * @return void
     *
     */
    public function addAction()
    {
        $newUserID = 0;
        $usersRaces = $this->userModel->getUsersRacesDefault();
        $usersGenders = $this->userModel->getUsersGendersDefault();
        $usersPlacebirth = $this->userModel->getUsersPlaceBirthAvailable();
        $checkedData = $this->userModel->validateAddUserForm($_POST);

        // Check if submit and valid form
        if ($checkedData['isSubmitForm'] && $checkedData['isValidForm']) {
            // Save new user
            $newUserID = $this->userModel->save($checkedData['formData']['user']);
            if (!$newUserID) {
                $checkedData['isValidForm'] = false;
                $checkedData['errorMessage'][] = 'Error!!! Can\'t save new User. Please try again.';
            }
        }

        $this->view('users/add', [
            'newUserID' => $newUserID,
            'usersRaces' => $usersRaces,
            'usersGenders' => $usersGenders,
            'usersPlacebirth' => $usersPlacebirth,
            'isValidForm' => $checkedData['isValidForm'],
            'isSubmitForm' => $checkedData['isSubmitForm'],
            'errorMessage' => implode('<br>', $checkedData['errorMessage']),
            'formData' => $checkedData['formData'],
            'formErrors' => $checkedData['formErrors'],
        ]);
    }

    /**
     * The default controller method
     *
     * @param int $userID
     *
     * @return void
     *
     */
    public function deleteAction($userID = 0)
    {
        $this->userModel->delete($userID);
        $queryString = Helpers::getQueryString();
        $path = ltrim($queryString, 'redirect_to=');
        $redirectTo = Helpers::path('users/table');
        if ($path) {
            $redirectTo = Helpers::path($path);
        }
        header("Location: " . $redirectTo);
        die();
    }


}