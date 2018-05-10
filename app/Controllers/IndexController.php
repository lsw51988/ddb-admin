<?php

namespace Ddb\Controllers;

use Ddb\Core\BaseController;
use Ddb\Models\MemberBikeImages;

class IndexController extends BaseController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        echo "welcome";
    }

    public function route404Action()
    {

    }

    /**
     * @Get("/bikeImg/{id:[0-9]+}")
     * 查看电动车照片
     */
    public function bikeImgAction($id){
        if(!$memberBikeImage = MemberBikeImages::findFirst($id)){
            return $this->error("找不到图片");
        }
        $path = $memberBikeImage->getPath();
        $data = service("file/manager")->read($path);
        return $this->response->setContent($data['contents'])->setContentType('image/jpeg');
    }
}