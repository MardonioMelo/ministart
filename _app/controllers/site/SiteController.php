<?php

namespace App\Controllers\Site;

use App\Controllers\All\Controller;
use App\Models\Newsletter;
use App\Helpers\Session;

/**
 * Class SiteController
 * @package App\Controllers\Site
 *
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
 */
class SiteController extends Controller
{

    /** @var Newsletter */
    private $Newsletter;
    /** @var Session */
    private $Session;
    private $Data;
    private $jSon;


    public function __construct()
    {
        $this->setBasic();
    }

    public function home()
    {
        $this->Data['page'] = 'home';

        $this->setSession();
        $this->setMount('content_home');
    }

    /**
     * Termos de uso
     */
    public function termos()
    {
        $this->Data['title'] = "Termos e Condições de Uso | " . SITENAME;
        $this->setMount('content_terms');
    }

    /**
     * Página de registro
     */
    public function pageRegister()
    {
        $this->Data['title'] = "Cadastre-se | " . SITENAME;
        $this->setMount('register', false);
    }

    /**
     * Função para montar o site
     * @param $content = Informe o nome do template do conteúdo
     * @param bool $footer
     */
    public function setMount($content, $footer = true)
    {
        $this->setData();

        $tpl_content = $this->View->Load('site/header');
        $this->Data['header'] = $this->View->ReturnTemplate($this->Data, $tpl_content);

        $tpl_content = $this->View->Load('site/' . $content);
        $this->Data['content'] = $this->View->ReturnTemplate($this->Data, $tpl_content);

        if ($footer) {
            $tpl_footer = $this->View->Load('site/footer');
            $this->Data['footer'] = $this->View->ReturnTemplate($this->Data, $tpl_footer);
        } else {
            $this->Data['footer'] = '';
        }

        $tpl = $this->View->Load('site/home');
        $this->View->Show($this->Data, $tpl);
    }

    /*
    * ***************************************
    * **********       API         **********
    * ***************************************
    */

    /**
     * Cadastra email para News Letter
     * @param $data
     */
    public function newsletter($data)
    {
        $this->Newsletter = new Newsletter();
        $this->Newsletter->ExeCreate($data);

        $this->jSon['exit']['success'] = $this->Newsletter->getResult();
        $this->jSon['exit']['error'] = $this->Newsletter->getError();

        $this->View->Request(REQUIRE_PATH . "/api/json", $this->jSon);
    }

    /*
    * ***************************************
    * **********  PRIVATE METHODS  **********
    * ***************************************
    */

    /**
     * Iniciar a sessão do visitante
     */
    private function setSession()
    {
        if (!isset($_SESSION['useronline'])) {
            $this->Session = new Session();
        }
    }

    /**
     * SEO e parâmetros
     */
    private function setData()
    {
        //SEO Meta Tags
        $this->Data['title'] = empty($this->Data['title']) ? SITEDESC . ' | ' . SITENAME : $this->Data['title'];
        $this->Data['theme_color'] = '#6f42c1';
        $this->Data['description'] = "Conheça o Ministart, um sistema framework simples.";
        $this->Data['author'] = "Startmelo";
        $this->Data['keywords'] = 'framework, work, PHP, etc';

        //OG Meta Tags para melhorar a aparência da postagem quando você compartilha a página LinkedIn, Facebook, Google+
        $this->Data['og_site_name'] = SITEDESC . ' | ' . SITENAME; //website name
        $this->Data['og_locale'] = "pt_BR";
        $this->Data['og_site'] = "https://www.startmelo.com.br/"; //website link
        $this->Data['og_title'] = SITEDESC . ' | ' . SITENAME; //título mostrado na postagem compartilhada real
        $this->Data['og_description'] = "Conheça o Ministart, um sistema framework simples"; //descrição mostrada na postagem compartilhada real
        $this->Data['og_image'] = INCLUDE_PATH . '/site/images/post-social.png'; //link de imagem
        $this->Data['og_url'] = "https://www.startmelo.com.br/"; //para onde você deseja que seu post seja vinculado
        $this->Data['og_type'] = "article"; //tipo da página

        //Local do CSS e JS
        $this->Data['INCLUDE_PATH'] = INCLUDE_PATH . '/site';
        $this->Data['INCLUDE_PATH_ASSETS'] = INCLUDE_PATH . '/assets';
    }

}