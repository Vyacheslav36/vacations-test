<?php
$config = [
    'homeUrl' => Yii::getAlias('@backendUrl'),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'vacation/index',
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'baseUrl' => env('BACKEND_BASE_URL'),
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class,
        ],
    ],
    'modules' => [
        'content' => [
            'class' => backend\modules\content\Module::class,
        ],
        'widget' => [
            'class' => backend\modules\widget\Module::class,
        ],
        'file' => [
            'class' => backend\modules\file\Module::class,
        ],
        'system' => [
            'class' => backend\modules\system\Module::class,
        ],
        'translation' => [
            'class' => backend\modules\translation\Module::class,
        ],
        'rbac' => [
            'class' => backend\modules\rbac\Module::class,
            'defaultRoute' => 'rbac-auth-item/index',
        ],
    ],
    'on beforeAction' => function ($event) {
        $availableControllers = [
            'manager' => [
                'vacation' => [
                    'index' => true,
                    'create' => true,
                    'view' => true,
                    'update' => true,
                ],
                'sign-in' => [
                    'profile' => true,
                    'account' => true,
                    'login' => true,
                    'logout' => true,
                    'avatar-upload' => true,
                ],
                'user' => [
                    'index' => true,
                    'create' => true,
                    'update' => true,
                ],
                'department' => [
                    'index' => true,
                    'update' => true,
                ],
                'storage' => [
                    'upload' => true,
                ],
                'site' => [
                    'error' => true,
                ],
            ],
            'user' => [
                'vacation' => [
                    'index' => true,
                    'create' => true,
                    'update' => true,
                    'view' => true,
                ],
                'sign-in' => [
                    'profile' => true,
                    'account' => true,
                    'login' => true,
                    'logout' => true,
                    'avatar-upload' => true,
                ],
                'storage' => [
                    'upload' => true,
                ],
                'site' => [
                    'error' => true,
                ],
            ]
        ];
        if (!Yii::$app->user->can(\common\models\User::ROLE_ADMINISTRATOR) && !Yii::$app->user->isGuest
            && (!isset($availableControllers[Yii::$app->user->identity->roleName][$event->action->controller->id][$event->action->id])
                || !$availableControllers[Yii::$app->user->identity->roleName][$event->action->controller->id][$event->action->id])
        ) {
            $getFirstAvailablePath = function ($availableControllers) {
                foreach ($availableControllers as $controller => $actionList) {
                    foreach ($actionList as $action => $isAvailable) {
                        if ($isAvailable) {
                            return "/$controller/$action";
                        }
                    }
                }
                return '/';
            };
            $firstPath = $getFirstAvailablePath($availableControllers[Yii::$app->user->identity->roleName]);
            Yii::$app->getResponse()->redirect(
                Yii::$app->urlManagerBackend->createAbsoluteUrl($firstPath)
            )->send();
            return;
        }
    },
    'as globalAccess' => [
        'class' => common\behaviors\GlobalAccessBehavior::class,
        'rules' => [
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions' => ['login'],
            ],
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions' => ['logout'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions' => ['error'],
            ],
            [
                'controllers' => ['debug/default'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'controllers' => ['user'],
                'allow' => true,
                'roles' => ['administrator', 'manager'],
            ],
            [
                'controllers' => ['user'],
                'allow' => false,
            ],
            [
                'allow' => true,
                'roles' => ['administrator', 'manager', 'user'],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'generators' => [
            'crud' => [
                'class' => yii\gii\generators\crud\Generator::class,
                'templates' => [
                    'yii2-starter-kit' => Yii::getAlias('@backend/views/_gii/templates'),
                ],
                'template' => 'yii2-starter-kit',
                'messageCategory' => 'backend',
            ],
        ],
    ];
}

return $config;
