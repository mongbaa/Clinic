<?php

namespace Geriatric\Controllers\Authentication;

use \Geriatric\Libraries\Authentication as Auth;

class SignInPost extends \Geriatric\Controllers\BaseController
{
    public function process()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hash function.
        $md5HashedPassword = \hash('md5', $password);
        $sha256HashedPassword = \hash('sha256', $password);

        $authenPass = false;
        $count = 0;

        while($authenPass == false && $count < 2)
        {
            // Check user exists.
            if (Auth::hasUserSystem($username))
            {
                $user = Auth::LoadUserSystem($username);    
                $password = $user->password;
                $isMatchPassword = false;

                if ($user->authenType == 'hosxp') {
                    $userHosxpModel = new \Geriatric\Models\UserHosxpModel();
                    $userHosxp = $userHosxpModel->getUser($username);
                    $password = $userHosxp['passweb'];
                    $isMatchPassword = Auth::pairHashedPassword($md5HashedPassword, $password);

                    if ($isMatchPassword) {
                        $this->updatePassword($user->userID, $password);
                    }
                } else {
                    $isMatchPassword = Auth::pairHashedPassword($sha256HashedPassword, $password);
                }

                
                if ($user != null && $user->active == true && $isMatchPassword)
                {
                    $authenPass = true;
                    Auth::saveUserSession($user);

                    header('location: ' . \Path::absolute('/'));
                    exit;
                }
                else
                {
                    header('location: ' . \Path::absolute('/signin'));
                    exit;
                }
            }
            else // Try transfer user from hosxp.
            {
                $success = $this->createUser($username);
                if ($success)
                {
                    $count++;
                    continue;
                }
                // this user is invalid don't try login after loaduser.
                break;
            }

            // Make sure this loop must end.
            $count++;
        }
        header('location: ' . \Path::absolute('/signin'));
        exit;
    }


    /**
     * Create new user.
     * 
     * @return { boolean }  $insert_id
     */
    private function createUser($username)
    {
        $userHosxpModel = new \Geriatric\Models\UserHosxpModel();

        if ($userHosxpModel->hasUser($username))
        {
            $userInfo = $userHosxpModel->getUser($username);

            if ($userInfo != null)
            {
                $conn = \Geriatric\Models\DB::getConnection($this->app->config->systemDB);
                $userModel = new \Geriatric\Models\UserModel($conn);

                $conn->begin_transaction();

                $userID = $userModel->createUser([
                    'prefixname'    => $userInfo['pname'],
                    'firstname'     => $userInfo['fname'],
                    'middlename'    => '',
                    'lastname'      => $userInfo['lname'],
                    'fullname'      => $userInfo['name'],
                    'username'      => $userInfo['loginname'],
                    'password'      => $userInfo['passweb'],
                    'userType'      => $userInfo['doctor_type_name'],
                    'active'        => ($userInfo['active'] == 'Y') ? 1 : 0
                ]);

                $userGroupList = [];

                if ($userInfo['doctor_type_name'] == 'อาจารย์ทันตแพทย์')
                {
                    $userGroupList[] = 'lecture';
                }
                else // Default user have postgrad permission.
                {
                    $userGroupList[] = 'postgrad';
                }


                $result = $userModel->addUserGroups($userID, $userGroupList);

                // Save.
                if ($result == true) { $conn->commit(); }

                return $result;
            }
        }
        return false;
    }


    /**
     * update user password
     */
    public function updatePassword($userID, $newPassword)
    {
        $conn = \Geriatric\Models\DB::getConnection($this->app->config->systemDB);
        $conn->query(" update User set password = '$newPassword' where userID = '$userID' ");
    }
}

?>
