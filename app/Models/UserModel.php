<?php

namespace Models;

use Core\Helpers;

/**
 * This is Description of User class
 *
 */
class UserModel extends Model
{

    /**
     * Description:
     *
     * @return array
     *
     */
    public function getColumnsNameForOrderBy()
    {
        return ['id', 'name', 'datebirth', 'created_at'];
    }

    /**
     * Description:
     *
     * @return array
     *
     */
    public function getColumnsNameForSelected()
    {
        return ['id', 'name','gender', 'race', 'placebirth', 'datebirth', 'is_carriedring', 'is_enslaved', 'crimes', 'notes', 'created_at'];
    }


    /**
     * Description:
     *
     * @return array
     *
     */
    public function getUsersRacesDefault()
    {
        return ['dwarf', 'elf', 'ghost', 'hobbit', 'human', 'orc'];
    }

    /**
     * Description:
     *
     * @return array
     *
     */
    public function getUsersGendersDefault()
    {
        return ['male', 'female', 'unknown'];
    }

    /**
     * Description:
     *
     * @return array $placebirth
     *
     */
    public function getUsersPlaceBirthAvailable()
    {
        $placebirth = [];

        $sql = "SELECT `placebirth` FROM `Users` GROUP BY `placebirth`";

        // Prepare and execute SQL query
        try {
            $stmn = $this->db->prepare($sql);
            $stmn->execute();
            $stmn->setFetchMode(\PDO::FETCH_ASSOC);

            if ($stmn->rowCount()){
                $rows = $stmn->fetchAll();
                foreach ($rows as $row) {
                    $placebirth[] = $row['placebirth'];
                }
                sort($placebirth, SORT_NATURAL | SORT_FLAG_CASE);
            }

        } catch (\PDOException $e) {
            //echo $e->getMessage();
        }


        return $placebirth;
    }

    /**
     * Description:
     *
     * @return array $races
     *
     */
    public function getUsersRacesAvailable()
    {
        $races = [];

        $sql = "SELECT `race` FROM `Users` GROUP BY `race`";

        // Prepare and execute SQL query
        try {
            $stmn = $this->db->prepare($sql);
            $stmn->execute();
            $stmn->setFetchMode(\PDO::FETCH_ASSOC);

            if ($stmn->rowCount()){
                $rows = $stmn->fetchAll();
                foreach ($rows as $row) {
                    $races[] = $row['race'];
                }
                sort($races, SORT_NATURAL | SORT_FLAG_CASE);
            }

        } catch (\PDOException $e) {
            //echo $e->getMessage();
        }

        return $races;
    }

    /**
     * Description:
     *
     * @return array $cols
     *
     */
    public function getColumnsMeta()
    {
        $cols = [];
        $orderbyColumns = $this->getColumnsNameForOrderBy();
        $selectedColumns = $this->getColumnsNameForSelected();

        foreach ($selectedColumns as $columnName) {
            $orderbyUri = '';
            $col = [];
            $htmlClasses = [];
            $htmlClasses[] = (strtolower($columnName) == 'crimes') ? 'w10' : '';
            $htmlClasses[] = (strtolower($columnName) == 'notes') ? 'w10' : '';

            if (in_array(strtolower($columnName), $orderbyColumns)) {
                $queryString = Helpers::getQueryString();
                $queryString = $queryString ? '?' . $queryString : '';
                $orderbyUri = Helpers::path('users/table/orderby/' . $columnName . '/asc') . $queryString;
                $htmlClasses[] = 'order';
                if (Helpers::isCurrentURI('users/table/orderby/' . $columnName . '/asc')) {
                    $orderbyUri  = Helpers::path('users/table/orderby/' . $columnName . '/desc') . $queryString;
                    $htmlClasses[] = 'asc';
                    $htmlClasses[] = 'active';
                } else if (Helpers::isCurrentURI('users/table/orderby/' . $columnName . '/desc')) {
                    $htmlClasses[] = 'desc';
                    $htmlClasses[] = 'active';
                }
            }

            $col['columnName'] = $columnName;
            $col['htmlClasses'] = $htmlClasses ? implode(' ', array_filter($htmlClasses, 'strlen')) : '';
            $col['orderbyUri'] = $orderbyUri;
            $cols[] = $col;
        }

        return $cols;
    }

    /**
     * Description:
     *
     * @param array $args
     *
     * @return array $rows
     *
     */
    public function getUsers($args = [])
    {
        $data = [];

        $sql = '';
        $sqlWHERE = [];
        $rows = [];

        $orderbyColumns = $this->getColumnsNameForOrderBy();
        $selectedColumns = $this->getColumnsNameForSelected();
        $usersRaces = $this->getUsersRacesDefault();

        //Default Args
        $argsDefault = [
            "action" => "orderby",
            "orderby" => "id",
            "order" => "ASC",
            "filterby" => [
                'race' => '',
                'mincrimes' => '',
                'unpunished' => false,
                'submit' => '',
            ],
        ];

        // Check orderby params
        $args['action'] = isset($args['action']) ? strtolower(Helpers::clean($args['action'])) : $argsDefault['action'];
        $args['orderby'] = isset($args['orderby']) ? strtolower(Helpers::clean($args['orderby'])) : $argsDefault['orderby'];
        $args['order'] = isset($args['order']) ? strtoupper(Helpers::clean($args['order'])) : $argsDefault['order'];
        $args['orderby'] = ('orderby' == $args['action'] && in_array($args['orderby'], $orderbyColumns)) ? $args['orderby'] : $argsDefault['orderby'];
        $args['order'] = ('orderby' == $args['action'] && in_array($args['order'], ['ASC', 'DESC'])) ? $args['order'] : $argsDefault['order'];

        // Check filterby param
        $args['filterby'] = isset($args['filterby']) ? $args['filterby'] : $argsDefault['filterby'];
        $args['filterby']['race'] = isset($args['filterby']['race']) ? strtolower(Helpers::clean($args['filterby']['race'])) : $argsDefault['filterby']['race'];
        $args['filterby']['mincrimes'] = (isset($args['filterby']['mincrimes']) && is_numeric($args['filterby']['mincrimes']) && 0 <= (int)$args['filterby']['mincrimes']) ? (int)$args['filterby']['mincrimes'] : $argsDefault['filterby']['mincrimes'];
        $args['filterby']['unpunished'] = (isset($args['filterby']['unpunished']) && 1 == (int)$args['filterby']['unpunished']);
        $args['filterby']['submit'] = isset($args['filterby']['submit']) ? strtolower(Helpers::clean($args['filterby']['submit'])) : $argsDefault['filterby']['submit'];

        // Save Sanitized and Checked args;
        $data['args'] = $args;

        // Filterby race sub-query
        if (!empty($args['filterby']['race'])) {
            if (in_array($args['filterby']['race'], $usersRaces)) {
                $sqlWHERE[] = "`race` = '" . $args['filterby']['race'] . "'";
            } else {
                $excludedRaces = implode('\', \'', $usersRaces);
                $excludedRaces = '(\'' . $excludedRaces . '\')';
                $sqlWHERE[] = "`race` NOT IN " . $excludedRaces;
            }
        }

        // Filterby crimes sub-query
        if ('' !== $args['filterby']['mincrimes'] && 0 <= $args['filterby']['mincrimes']) {
            $sqlWHERE[] = "`crimes_total_count` > " . $args['filterby']['mincrimes'];
        }
        if ($args['filterby']['unpunished']) {
            $sqlWHERE[] = "`crimes_unpunished_count` > 0";
        }

        // Finished sub-query
        $sqlWHERE = $sqlWHERE ? 'WHERE ' . implode(' AND ', $sqlWHERE) : '';

        $selectedColumns = '`' . implode('`, `', $selectedColumns) . '`';

        $sql .= "SELECT $selectedColumns FROM `Users` $sqlWHERE ORDER BY `" . $args['orderby'] . "` " . $args['order'];

        // Prepare and execute SQL query
        try {
            $stmn = $this->db->prepare($sql);
            $stmn->execute();
            $stmn->setFetchMode(\PDO::FETCH_ASSOC);
            if ($stmn->rowCount()){
                $rows = $stmn->fetchAll();
            }
        } catch (\PDOException $e) {
            //echo $e->getMessage();
        }

        // decode some rows value from json data to array
        foreach ($rows as $index => $row) {
            $crimes = json_decode($row['crimes'], true);
            $notes = json_decode($row['notes'], true);
            $rows[$index]['crimes'] = is_array($crimes) ? $crimes : [];
            $rows[$index]['notes'] = is_array($notes) ? $notes : [];
            foreach ($rows[$index]['crimes'] as $idx => $crime) {
                ksort($crime);
                $rows[$index]['crimes'][$idx] = $crime;
            }
            foreach ($rows[$index]['notes'] as $idx => $note) {
                ksort($note);
                $rows[$index]['notes'][$idx] = $note;
            }
        }

        $data['users'] = $rows;

        $this->db = null;

        return $data;
    }

    /**
     * Description:
     *
     * @param string $for Prefix for column name in DB where stored admin password
     *
     * @return string $password_hash
     *
     */
    public function getAdminPassword($for = '')
    {
        $sql = '';
        $password = '';

        $sql .= "SELECT `" . $for . "_password` FROM `Admin` WHERE `name` = 'admin' LIMIT 1";

        // Prepare and execute SQL query
        try {
            $stmn = $this->db->prepare($sql);
            $stmn->execute();
            $stmn->setFetchMode(\PDO::FETCH_ASSOC);
            if ($stmn->rowCount()){
                $row = $stmn->fetchAll();
                $password = $row[0][$for . '_password'];
            }
        } catch (\PDOException $e) {
            //echo $e->getMessage();
        }

        return $password;
    }

    /**
     * Description:
     *
     * @param array $userData
     *
     * @return int $user_id
     *
     */
    public function save($userData)
    {
        $newUserID = 0;

        if (is_array($userData)) {
            $sql= '';
            $isInserted = false;

            $userColName = [];
            $userColParam = [];

            $userData['crimes_total_count'] = isset($userData['crimes_total_count']) ? $userData['crimes_total_count'] : 0 ;
            $userData['crimes_punished_count'] = isset($userData['crimes_punished_count']) ? $userData['crimes_punished_count'] : 0 ;
            $userData['crimes_unpunished_count'] = isset($userData['crimes_unpunished_count']) ? $userData['crimes_unpunished_count'] : 0 ;

            // Build sql query string
            foreach ($userData as $key => $val) {
                $userColName[] = '`' . $key . '`';
                $userColParam[] = ':' . $key;
                if ($key == 'crimes' && is_array($val)) {
                    $userData['crimes_total_count'] = count($val);
                    foreach ($val as $k => $v) {
                        if (isset($v['is_punished']) && $v['is_punished'] == 1) {
                            $userData['crimes_punished_count']++;
                        } else {
                            $userData['crimes_unpunished_count']++;
                        }
                    }
                }
            }

            $userColName = implode(', ', $userColName);
            $userColParam = implode(', ', $userColParam);

            $sql .= "INSERT INTO `Users` (" . $userColName . ") VALUES (" . $userColParam . ")";

            // Prepare and bind params and execute SQL query
            try {
                $stmn = $this->db->prepare($sql);
                foreach ($userData as $key => $val) {
                    // $$key - dynamic var name for column value;
                    // cause bindParam method take second param by reference;
                    $$key = is_array($val) ? $val ? json_encode($val) : '' : $val;
                    $stmn->bindParam(':' . $key, $$key);
                }
                //$this->db->beginTransaction();
                $isInserted = $stmn->execute();
                //$this->db->commit();
            } catch (\PDOException $e) {
                //echo $e->getMessage();
            }

            // get lastInsertId
            $newUserID = $isInserted ? $this->db->lastInsertId() : $newUserID;

        }

        $this->db = null;

        return $newUserID;
    }

    /**
     * Description:
     *
     * @param int $userID
     *
     * @return boolean $isDeleted
     *
     */
    public function delete($userID = 0)
    {
        $isDeleted = false;

        if ((int)$userID > 0) {
            $sql = "DELETE FROM `Users` WHERE `id` = :user_id";
            // Prepare and bind params and execute SQL query
            try {
                $stmn = $this->db->prepare($sql);
                $stmn->bindParam(':user_id', $userID, \PDO::PARAM_INT);
                $isDeleted = $stmn->execute();
            } catch (\PDOException $e) {
                $isDeleted = false;
                //echo $e->getMessage();
            }
        }

        $this->db = null;

        return $isDeleted;
    }

    /**
     * Description:
     *
     * @param string $password Form field data
     * @param string $for Prefix for column name in DB where stored admin password
     *
     * @return boolean
     *
     */
    public function isValidAdminPassword($password = '', $for = '')
    {
        $adminPasswordHash = $this->getAdminPassword($for);
        $hash = md5($password . AUTH_SALT);

        return (preg_match('/.{1,60}/', $password) && ($hash == $adminPasswordHash));
    }

    /**
     * The controller method
     *
     * @param array $formData The form data
     *
     * @return array $data The validity form data
     *
     */
    public function validateAccessTableForm($formData) {
        $errorsTotal = 0;

        $checkedData = [
            'formData' => [
                'adminPassword' => '',
            ],
            'formErrors' => [
                'adminErrors' => [
                    'password' => false
                ],
            ],
            'isValidForm' => null,
            'isAccessTable' => false,
            'errorMessage' => [],
        ];

        // Check if already AUTH admin
        if (Helpers::isAdminAuth()) {
            $checkedData['isAccessTable'] = true;
        } else {
            // Check If POST request and Form submit
            if (HELPERS::isRequestMethod('POST') && isset($formData['submit']) && $formData['submit'] == 'accessTable') {
                // Sanitize POST form data
                $formData = $this->sanitizeForm($formData);

                if (isset($formData['adminPassword'])) {
                    if ($this->isValidAdminPassword($formData['adminPassword'], 'access_table_form')) {
                        $checkedData['isAccessTable'] = true;
                        Helpers::adminAuth();
                    } else {
                        ++$errorsTotal;
                        $checkedData['formErrors']['adminErrors']['password'] = true;
                        $checkedData['errorMessage'][] = 'Invalid Admin Password!!!';
                    }
                }

                $checkedData['formData'] = $formData;
                $checkedData['isValidForm'] = ($errorsTotal == 0);

                if (!$checkedData['isValidForm']) {
                    $checkedData['errorMessage'][] = "Error!!! Invalid some form field. Please correct fill form field and try again.";
                }
            }
        }

        $checkedData['isValidForm'] = ($checkedData['isValidForm'] === null) ? true : $checkedData['isValidForm'];

        return $checkedData;
    }

    /**
     * The controller method
     *
     * @param array $formData The form data
     *
     * @return array $data The validity form data
     *
     */
    public function validateAddUserForm($formData)
    {
        $errorsTotal = 0;

        $checkedData = [
            'formData' => [
                'adminPassword' => '',
                'user' => [
                    'name' => '',
                    'gender' => '',
                    'race' => '',
                    'placebirth' => '',
                    'datebirth' => '',
                    'is_carriedring' => '',
                    'is_enslaved' => '',
                    'crimes' => [],
                    'notes' => [],
                    'created_at' => '',
                ],
            ],
            'formErrors' => [
                'userErrors' => [
                    'name' => false,
                    'gender' => false,
                    'race' => false,
                    'placebirth' => false,
                    'datebirth' => false,
                    'is_carriedring' => false,
                    'is_enslaved' => false,
                    'crimes' => [],
                    'notes' => [],
                    'created_at' => false,
                ],
                'adminErrors' => [
                    'password' => false
                ],
            ],
            'isValidForm' => null,
            'isSubmitForm' => false,
            'errorMessage' => [],
        ];

        // Check If POST request and Form submit
        if (HELPERS::isRequestMethod('POST') && isset($formData['submit']) && $formData['submit'] == 'addUser') {
            // Sanitize POST form data
            $formData = $this->sanitizeForm($formData);

            if (isset($formData['adminPassword']) && !$this->isValidAdminPassword($formData['adminPassword'], 'add_user_form')) {
                ++$errorsTotal;
                $checkedData['formErrors']['adminErrors']['password'] = true;
                $checkedData['errorMessage'][] = 'Invalid Admin Password!!!';
            }

            if (isset($formData['user']['name'])
                && !preg_match('/.{1,60}/', $formData['user']['name'])
            ) {
                ++$errorsTotal;
                $checkedData['formErrors']['userErrors']['name'] = true;
            }

            if (isset($formData['user']['gender'])
                && !preg_match('/.{1,60}/', $formData['user']['gender'])
            ) {
                ++$errorsTotal;
                $checkedData['formErrors']['userErrors']['gender'] = true;
            }

            if (isset($formData['user']['race'])
                && !preg_match('/.{1,60}/', $formData['user']['race'])
            ) {
                ++$errorsTotal;
                $checkedData['formErrors']['userErrors']['race'] = true;
            }

            if (isset($formData['user']['placebirth'])
                && !preg_match('/.{1,50}/', $formData['user']['placebirth'])
            ) {
                ++$errorsTotal;
                $checkedData['formErrors']['userErrors']['placebirth'] = true;
            }

            if (isset($formData['user']['datebirth'])
                && !preg_match('/[0-9]{4}-[01][0-9]-[0-3][0-9]/', $formData['user']['datebirth'])
            ) {
                ++$errorsTotal;
                $checkedData['formErrors']['userErrors']['datebirth'] = true;
            }

            $formData['user']['is_carriedring'] = (isset($formData['user']['is_carriedring']) && '1' == $formData['user']['is_carriedring']) ? 1 : 0;
            $formData['user']['is_enslaved'] = (isset($formData['user']['is_enslaved']) && '1' == $formData['user']['is_enslaved']) ? 1 : 0;
            $formData['user']['created_at'] = date('Y-m-d');

            // Validate crimes fields
            if (isset($formData['user']['crimes']) && is_array($formData['user']['crimes'])) {
                foreach ($formData['user']['crimes'] as $index => $crime) {
                    $formData['user']['crimes'][$index]['is_punished'] = (isset($formData['user']['crimes'][$index]['is_punished']) && '1' == $formData['user']['crimes'][$index]['is_punished']) ? 1 : 0;
                    $checkedData['formErrors']['userErrors']['crimes'][$index]['date'] = false;
                    $checkedData['formErrors']['userErrors']['crimes'][$index]['note'] = false;
                    if (isset($formData['user']['crimes'][$index]['date'])
                        && !preg_match('/[0-9]{4}-[01][0-9]-[0-3][0-9]/', $formData['user']['crimes'][$index]['date'])
                    ) {
                        ++$errorsTotal;
                        $checkedData['formErrors']['userErrors']['crimes'][$index]['date'] = true;
                    }
                    if (isset($formData['user']['crimes'][$index]['note'])
                        && !preg_match('/.{1,10000}/', $formData['user']['crimes'][$index]['note'])
                    ) {
                        ++$errorsTotal;
                        $checkedData['formErrors']['userErrors']['crimes'][$index]['note'] = true;
                    }
                }
            } else {
                $formData['user']['crimes'] = [];
            }

            // Validate notes fields
            if (isset($formData['user']['notes']) && is_array($formData['user']['notes'])) {
                foreach ($formData['user']['notes'] as $index => $note) {
                    $checkedData['formErrors']['userErrors']['notes'][$index]['date'] = false;
                    $checkedData['formErrors']['userErrors']['notes'][$index]['note'] = false;
                    if (isset($formData['user']['notes'][$index]['date'])
                        && !preg_match('/[0-9]{4}-[01][0-9]-[0-3][0-9]/', $formData['user']['notes'][$index]['date'])
                    ) {
                        ++$errorsTotal;
                        $checkedData['formErrors']['userErrors']['notes'][$index]['date'] = true;
                    }
                    if (isset($formData['user']['notes'][$index]['note'])
                        && !preg_match('/.{1,10000}/', $formData['user']['notes'][$index]['note'])
                    ) {
                        ++$errorsTotal;
                        $checkedData['formErrors']['userErrors']['notes'][$index]['note'] = true;
                    }
                }
            } else {
                $formData['user']['notes'] = [];
            }

            $checkedData['formData'] = $formData;
            $checkedData['isSubmitForm'] = true;
            $checkedData['isValidForm'] = ($errorsTotal == 0);

            if (!$checkedData['isValidForm']) {
                $checkedData['errorMessage'][] = "Error!!! Invalid some form field. Please correct fill form field and try again.";
            }
        }

        $checkedData['isValidForm'] = ($checkedData['isValidForm'] === null) ? true : $checkedData['isValidForm'];

        return $checkedData;
    }

    /**
     * The controller method
     *
     * @param array $data The form data
     *
     * @return array $data The sanitized form data
     *
     */
    protected function sanitizeForm($data)
    {
        foreach ($data as $key => $val) {
            $key = HELPERS::clean($key);
            $val = is_array($val) ? $this->sanitizeForm($val) : HELPERS::clean($val);
            $data[$key] = $val;
        }

        return $data;
    }

}