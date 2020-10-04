<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    // All view-functions go below

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'footer';
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    /*
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }*/

    /**
     * Logout action.
     *
     * @return Response
     */
    /*
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }*/

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    /*
    public function actionContact()
    {
        $this->layout = 'footer';
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }*/

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $this->layout = 'footer';
        return $this->render('about');
    }

    // Search results page
    public function actionSearch()
    {
        $query = Yii::$app->request->get('q');
        $query = trim($query);

        $this->layout = 'footer';
        
        if ($query === '') {
            return $this->render('index');
        }

        $page = Yii::$app->request->get('p');

        if ($page === null) {
            $page = 1;
        } else {
            $page = (int)$page;
        }

        $index = $this->get_ids($query, $page);
        if ($index === false) {
            return $this->render('noresults', ['query' => $query]);
        } elseif ($index === 'Error') {
            return $this->render('dberror', ['query' => $query, 'db' => 0]);
        }
        
        $maxpages = round($index[1] / 10);
        if ($maxpages > 10) {
            $maxpages = 10;
        }
        if ($maxpages < 1) {
            $maxpages = 1;
        }

        $results = $this->get_results($index[0]);

        if ($results === 'Error') {
            return $this->render('dberror', ['query' => $query, 'db' => 1]);
        }
        return $this->render('search', ['query' => $query, 'results' => $results, 
                                        'maxpages' => $maxpages, 'page' => $page]);
    }

    public function actionReport()
    {
        $this->layout = 'footer';
        $request = Yii::$app->request;
        $link = $request->post('r');
        if ($link === null) {
            return $this->render('nolinkreport');
        }
        return $this->render('report', ['link' => $link]);
    }

    public function actionRegistered()
    {
        $this->layout = 'footer';
        $request = Yii::$app->request;
        
        if ($request === []) {
            return $this->render('nolinkreport');
        }
        $post = $request->post();
        $this->register_rep($post);
        return $this->render('registered');
    }

    public function actionSerpdemo()
    {
        $this->layout = 'footer';
        return $this->render('serpdemo');
    }

    // Protected functions go below

    protected function get_tuple($arr)
    {
        $count = count($arr);

        $result = "";

        for ($i = 0; $i < ($count-1); $i++) {
            $result = $result . $arr[$i] . ", ";
        }

        $result = $result . $arr[$count - 1] . ")";
        $order = "(id, " . $result;
        $result = "(" . $result;

        return [$result, $order];
    }

    protected function get_ids($query, $page) {
        $indexer = Yii::$app->indexer;
        $page = ($page - 1) * 10;
        $indexquery = $indexer->createCommand("SELECT id FROM linkindexen WHERE MATCH(:query) LIMIT :page, :rpp
                    OPTION RANKER=expr('sum(wlccs*user_weight)*1000 + bm25'),
                    field_weights=(title=20, keywords=5, link=1, description=5, body=2);");

        try {
            $query = '"' . $query . '"/1';
            $ids = $indexquery->bindValues([':query' => $query, ':page' => $page, ':rpp' => 10])->queryAll();
        } catch (\Exception $e) {
            Yii::error("Manticore error:\n" . $e);
            return 'Error';
        }

        if (!$ids) return false;

        $ids = array_column($ids, 'id');
        $metas = $indexer->createCommand('SHOW META;')->queryAll();
        foreach ($metas as $meta) {
            if ($meta['Variable_name'] === 'total') {
                $maxres = $meta['Value'];
            }
        }

        return [$ids, $maxres];
    }

    protected function get_results($ids) {
        $searchdb = Yii::$app->db;
        
        $id_tuple = $this->get_tuple($ids);

        try {
            $dbquery = $searchdb->createCommand("SELECT title, link, description FROM links WHERE
                                                id IN $id_tuple[0] ORDER BY FIELD $id_tuple[1];")
            ->queryAll();
        } catch(\Exception $e) {
            Yii::error("MySQL error:\n" . $e);
            return 'Error';
        }
        
        return $dbquery;
    }

    protected function register_rep($arr) {
        Yii::$app->db->createCommand()->insert('reports', [
            'link' => $arr['link'],
            'value' => $arr['issue'],
            'details' => $arr['details'],
            'email' => $arr['email']
        ])->execute();
    }
}
