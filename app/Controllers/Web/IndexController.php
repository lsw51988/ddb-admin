<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2019/4/21
 * Time: 22:24
 */

namespace Ddb\Controllers\Web;


use Ddb\Core\ViewBaseController;

class IndexController extends ViewBaseController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {

    }

    /**
     * @Get("/business_license_img")
     * 营业执照
     */
    public function businessLicenseImgAction()
    {
        ob_clean();
        header("Content-type:image/jpeg");
        $this->response->setContentType('image/jpeg');
        $this->response->setContent(file_get_contents(APP_PATH."/../public/img/qr_code.jpg"));
        return $this->response;
    }
}