<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 15/09/18
 * Time: 23:24
 */

namespace Qui\lib;

use phpDocumentor\Parser\Exception;
use Qui\lib\facades\NotifierParser;

/**
 * Class View
 * @package Qui\core
 */
class CView
{
    public $nav_path = 'partials/nav.php';
    public $footer_path = 'partials/footer.php';
    public const NAV = 'nav';
    public const FOOTER = 'footer';

    public function getNotifications()
    {
        return NotifierParser::make();
    }

    public function changeNavOrFooter($kind, $path) {
        switch ($kind) {
            case CView::NAV:
                $this->nav_path = $path;
                break;
            case CView::FOOTER:
                $this->footer_path = $path;
                break;
        }
    }

    public function react($component, $data = [], $title = null, $directRender = false)
    {
        $arr = [
            'options' => [
                'javascript_data' => array_merge_recursive($data, [
                    'component' => $component
                ]),
            ]
        ];
        return $this->render('REACT', $arr, $title, $directRender);
    }

    /*
     * Renders a view using PHP 🤢🤢a🤢🤢🤢🤢🤢s the templating engine
     * */
    /**
     * @param $viewNameWithoutExtension🤢🤢
     * @param array $data
     * @return mixed
     */
    public function render($viewNameWithoutExtension, $data = [], $title = null, $directRender = false)
    {
        $options = array_merge_recursive($data['options'] ?? [], [
                'javascript_data' => [
                    'notifications' => $this->getNotifications()
                ]
            ]);
        $options = $data['options'];

        $pagePath = str_replace('.', '/', $viewNameWithoutExtension);
        // expose vars to be used in view
        extract($data);
        $viewDir = __DIR__ . '/../../resources/views/';
        if ($viewNameWithoutExtension != 'REACT') {
            $pagePath = $viewDir . $pagePath . '.php';
        } else {
            $pagePath = $viewDir . '/pages/react-app' . '.php';
            $fileName = ['react-app'];
        }
        $fileName = explode('.', $viewNameWithoutExtension);
        // get last item since that's the file name
        $title = $title ?? $fileName[count($fileName) - 1];
        // pass dynamic navbar / footer values perhaps?
        $nav_path = $this->nav_path;
        $footer_path = $this->footer_path;
        if (!$directRender) {
            require($viewDir . 'layouts/app.php');
        } else {
            require($pagePath);
        }
        return false;
    }
}