<?php

namespace backend\models;

use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Create user form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;
    public $roles;
    public $user_id;
    public $locale;
    public $department_id;
    public $firstname;
    public $middlename;
    public $avatar_path;
    public $avatar_base_url;
    public $lastname;
    public $picture;
    public $gender;

    private $model;
    private $userProfileModel;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            [
                ['username', 'filter', 'filter' => 'trim'],
                ['username', 'required'],
                ['username', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                    if (!$this->getModel()->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->getModel()->id]]);
                    }
                }],
                ['username', 'string', 'min' => 2, 'max' => 255],

                ['email', 'filter', 'filter' => 'trim'],
                ['email', 'required'],
                ['email', 'email'],
                ['email', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                    if (!$this->getModel()->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->getModel()->id]]);
                    }
                }],

                ['password', 'required', 'on' => 'create'],
                ['password', 'string', 'min' => 6],

                [['status'], 'integer'],
                [['roles'], 'each',
                    'rule' => ['in', 'range' => ArrayHelper::getColumn(
                        Yii::$app->authManager->getRoles(),
                        'name'
                    )]
                ],
            ],
            $this->getUserProfileRules(['user_id'])
        );
    }

    /**
     * @return User
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new User();
        }
        return $this->model;
    }

    /**
     * @return UserProfile
     */
    public function getUserProfileModel()
    {
        if (!$this->userProfileModel) {
            $this->userProfileModel = new UserProfile();
        }
        return $this->userProfileModel;
    }

    /**
     * @param User $model
     * @return mixed
     */
    public function setModel($model)
    {
        $this->username = $model->username;
        $this->email = $model->email;
        $this->status = $model->status;
        $this->model = $model;
        $this->roles = ArrayHelper::getColumn(
            Yii::$app->authManager->getRolesByUser($model->getId()),
            'name'
        );
        return $this->model;
    }

    /**
     * @param $model
     * @return mixed
     */
    public function setUserProfileModel($model)
    {
        $this->user_id = $model->user_id;
        $this->locale = $model->locale;
        $this->firstname = $model->firstname;
        $this->middlename = $model->middlename;
        $this->lastname = $model->lastname;
        $this->picture = $model->picture;
        $this->gender = $model->gender;
        $this->department_id = $model->department_id;
        $this->userProfileModel = $model;

        return $this->userProfileModel;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(
            [
                'username' => Yii::t('common', 'Username'),
                'email' => Yii::t('common', 'Email'),
                'status' => Yii::t('common', 'Status'),
                'password' => Yii::t('common', 'Password'),
                'roles' => Yii::t('common', 'Roles')
            ],
            (new UserProfile())->attributeLabels()
        );
    }

    /**
     * Signs user up.
     * @return bool|User|null
     * @throws Exception
     */
    public function save()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $userProfileModel = $this->getUserProfileModel();
            $isNewRecord = $model->getIsNewRecord();
            $model->username = $this->username;
            $model->email = $this->email;
            $model->status = $this->status;
            if ($this->password) {
                $model->setPassword($this->password);
            }
            $userProfileModel->locale = $this->locale;
            $userProfileModel->firstname = $this->firstname;
            $userProfileModel->middlename = $this->middlename;
            $userProfileModel->lastname = $this->lastname;
            $userProfileModel->picture = $this->picture;
            $userProfileModel->gender = $this->gender;
            $userProfileModel->department_id = $this->department_id;

            $transaction = Yii::$app->db->beginTransaction();
            if (!$model->save()) {
                $transaction->rollBack();
                throw new Exception('Model not saved');
            }

            $userProfileModel->user_id = $model->id;

            if ($isNewRecord) {
                $model->afterSignup($userProfileModel->toArray());
            } else {
                if (!$userProfileModel->save()) {
                    $transaction->rollBack();
                    throw new Exception('UserProfileModel not saved');
                }
            }

            $auth = Yii::$app->authManager;
            $auth->revokeAll($model->getId());

            if ($this->roles && is_array($this->roles)) {
                foreach ($this->roles as $role) {
                    $auth->assign($auth->getRole($role), $model->getId());
                }
            }

            $transaction->commit();

            return !$model->hasErrors();
        }
        return null;
    }

    /**
     * @param $isOwnRecord
     * @return array
     */
    public function getAccessibleRoleList($isOwnRecord = false)
    {
        $notAllowedRoles = [];
        if (!Yii::$app->user->can(User::ROLE_ADMINISTRATOR)) {
            $notAllowedRoles = array_merge($notAllowedRoles, [User::ROLE_ADMINISTRATOR]);
            if (!$isOwnRecord) {
                $notAllowedRoles = array_merge($notAllowedRoles, [User::ROLE_MANAGER]);
            }
        }
        $allRoles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
        $roleList = [];
        foreach ($allRoles as $roleName) {
            if (!in_array($roleName, $notAllowedRoles)) {
                $roleList[$roleName] = $roleName;
            }
        }
        return $roleList;
    }

    /**
     * @return array
     */
    public static function getListForSelect($onlyManagers = false)
    {
        $query = User::find();

        if ($onlyManagers) {
            $query->onlyManagers();
        }

        if (!\Yii::$app->user->can(User::ROLE_ADMINISTRATOR)) {
            $query->forManager(\Yii::$app->user->id);
        }
        $result = [];
        $users = $query->all();
        foreach ($users as $item) {
            $result[$item->id] = $item->publicIdentity;
        }

        return $result;
    }

    /**
     * @param array $fieldsToRemove
     * @return array
     */
    private function getUserProfileRules(array $fieldsToRemove = [])
    {
        $userProfileAttributes = (new UserProfile())->rules();
        foreach ($fieldsToRemove as $field) {
            if (isset($userProfileAttributes[$field])) {
                unset($userProfileAttributes[$field]);
            }
        }

        return $userProfileAttributes;
    }
}
