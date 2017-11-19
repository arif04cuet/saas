<?php
namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfFeedbackForm;
use Vokuro\Forms\NpfFormspayForm;
use Vokuro\Models\NpfFeedback;
use Vokuro\Models\NpfFormspay;

class FeedbackController extends ControllerBase
{

    public function initialize()
    {
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfFeedbackForm();
        new \Phalcon\Session\Adapter\Files();
    }

    public function listAction()
    {
        $numberPage = 1;
        $domain = array('domain_id' => $this->getDomainId());
        $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfFeedback', array_merge($domain, $this->request->get()));
        $this->persistent->searchParams = $query->getParams();
        $numberPage = $this->request->getQuery("page", "int");


        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }
        $parameters['order'] = 'created desc';
        $npfFeedback = NpfFeedback::find($parameters);
        if (count($npfFeedback) == 0) {
            $this->flash->notice("The search did not find any Feedback");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfFeedback,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }

    public function searchAction()
    {
        $numberPage = 1;
        $domain = array('domain_id' => $this->getDomainId());
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfFeedback', array_merge($domain, $this->request->getPost()));
            $this->persistent->searchParams = $query->getParams();
        } else {

            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfFormspay', array_merge($domain, $this->request->get()));
            $this->persistent->searchParams = $query->getParams();
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }
        $parameters['order'] = 'created desc';
        $npfFeedback = NpfFeedback::find($parameters);
        if (count($npfFeedback) == 0) {
            $this->flash->notice("The search did not find any Form");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfFeedback,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }

    public function showAction($id)
    {
        $feedback = NpfFeedback::findFirst("id='$id'");
        if (!$feedback) {
            $this->flash->error("Lookup was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }
        $this->view->feedback = $feedback->getFields();
    }

    public function createAction()
    {
        $this->view->disable();
        $msg = "";
        $postData = $this->request->get();
        if (isset($postData['name'])) {

            $feedback = new NpfFeedback();
            $arr_uri = explode("=", $_SERVER["REQUEST_URI"]);
            $formName = $postData['form_name'];
            unset($postData['form_name']);
            $flds = serialize($postData);
            $uuid = $this->uuid->v4();
            $feedback->assign(array(
                'id' => $uuid,
                'domain_id' => $this->getDomainId(),
                'form_name' => $formName,
                'form_fields' => $flds,
                'useragent' => $_SERVER['HTTP_USER_AGENT'],
                'userip' => $_SERVER['REMOTE_ADDR'],
            ));

            if ($postData["ct_captcha"] != $this->session->get('captcha_feedback_form')) {
                $msg = "captcha";
            } else {
                if (!$feedback->save()) {
                    $msg = "failed";
                } else {
                    $msg = "success";

                    //send mail to
                    $params = $postData;
                    $sent = $this->mail->send(
                        array(
                            'feedbackweb@pmo.gov.bd' => 'Feedback Web'
                        ),
                        "a feedback has been submitted",
                        'feedback',
                        $params
                    );

                }
            }

        }

        echo 'getConfirmation(' . json_encode(array('msg' => $msg)) . ')';
        exit;
    }

    public function storeAction()
    {
        /* $this->view->disable();
         $msg = "";
         $data = array();
         if ($_POST) {
             $postData = $this->request->getPost();
             $feedback = new NpfFeedback();
             $flds = serialize($postData);
             $uuid = $this->uuid->v4();
             $feedback->assign(array(
                 'id' => $uuid,
                 'domain_id' => '5934',
                 'form_name' => 'feedback_form',
                 'form_fields' => $flds,
                 'useragent' => 'bot',
                 'userip' => '127.0.0.1',
             ));


             if (!$feedback->save()) {
                 $data['msg'] = "error";
                 $data['error'] = $feedback->getMessages();
             } else {
                 $data['msg'] = "success";
             }

         } else {
             $data['msg'] = 'Please only get method';
         }

         echo json_encode($data);*/
        exit;

    }

    public function deleteAction($id)
    {
        $msg = '';
        $feedback = NpfFeedback::findFirst(array('id' => $id));
        if ($feedback != false) {
            if ($feedback->delete() == false) {
                $msg = "Sorry, we can't delete the feedback right now: \n";
                foreach ($feedback->getMessages() as $message) {
                    $msg .= $message . "\n";
                }
            } else {
                $msg = "The feedback was deleted successfully!";
            }
        }
        $this->flash->success($msg);
        return $this->dispatcher->forward(array('action' => 'list'));

    }

    public function LoadPNG($imgname)
    {
        /* Attempt to open */
        $im = @imagecreatefrompng($imgname);

        /* See if it failed */
        if (!$im) {
            /* Create a blank image */
            $im = imagecreatetruecolor(150, 30);
            $bgc = imagecolorallocate($im, 255, 255, 255);
            $tc = imagecolorallocate($im, 0, 0, 0);

            imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

            /* Output an error message */
            imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
        }

        return $im;
    }

    public function captchaAction()
    {
         $code = substr(number_format(time() * mt_rand(), 0, '', ''), 0, 4);
         $this->session->set('captcha_feedback_form', $code);
         $im = imagecreatetruecolor(100, 30);
         $bg = imagecolorallocate($im, 22, 86, 165); //background color blue
         $fg = imagecolorallocate($im, 255, 255, 255); //text color white
         imagefill($im, 0, 0, $bg);
         imagestring($im, 20, 5, 5, $code, $fg);
         header("Cache-Control: no-cache, must-revalidate");
         header('Content-type: image/png');
         imagepng($im);
         imagedestroy($im);
         exit;


    }

    public function demoAction()
    {


        $postData = $this->session->get('captcha_feedback_form');

        echo 'getConfirmation(' . json_encode(array('msg' => $postData)) . ')';
        exit;

    }

    public function supportAction()
    {

        if ($this->request->isPost()) {

            $user = $this->auth->getUser()->toArray();
            $domain = array('domain' => $this->getDomainName());
            $postData = $this->request->getPost();
            $params = array_merge($postData, $user, $domain);
            $sent = $this->mail->send(
                array(
                    //$this->config->mail->smtp->username => $this->config->mail->fromName
                    'arif04cuet2@gmail.com' => 'Arif'
                ),
                "Support form has been submitted",
                'support',
                $params
            );
            if ($sent) {
                $msg = 'Email has been sent successfully';
                $this->flash->success($msg);
                return $this->dispatcher->forward(array('action' => 'support'));
            }
        }
    }
}