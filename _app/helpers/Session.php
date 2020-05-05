<?php

namespace App\Helpers;


use App\Conn\TableViews;
use App\Conn\TableViewsAgent;
use App\Conn\TableViewsOnline;

/**
 * Session.class [ HELPER ]
 * Responsável pelas estatísticas, sessões e atualizações de tráfego do sistema!
 *
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
 */
class Session
{

    private $Date;
    private $Cache;
    private $Traffic;
    private $Browser;
    /** @var TableViews */
    private $siteViews;
    /** @var TableViewsAgent */
    private $siteViewsAgent;
    /** @var TableViewsOnline */
    private $siteViewsOnline;

    /**
     * Session constructor.
     * @param null $Cache
     */
    function __construct($Cache = null)
    {
        $this->siteViews = new TableViews();
        $this->siteViewsAgent = new TableViewsAgent();
        $this->siteViewsOnline = new TableViewsOnline();
        $this->CheckSession($Cache);
    }

    /**
     * Verifica e executa todos os métodos da classe!
     * @param null $Cache
     */
    private function CheckSession($Cache = null)
    {
        $this->Date = date('Y-m-d');
        $this->Cache = ((int)$Cache ? $Cache : 20);

        if (empty($_SESSION['useronline'])):
            $this->setTraffic();
            $this->setSession();
            $this->CheckBrowser();
            $this->setUsuario();
            $this->BrowserUpdate();
        else:
            $this->TrafficUpdate();
            $this->sessionUpdate();
            $this->CheckBrowser();
            $this->UsuarioUpdate();
        endif;

        $this->Date = null;
    }

    /*
     * ***************************************
     * ********   SESSÃO DO USUÁRIO   ********
     * ***************************************
     */

    /**
     * Inicia a sessão do usuário
     */
    private function setSession()
    {
        $_SESSION['useronline'] = [
            "online_session" => session_id(),
            "online_startview" => date('Y-m-d H:i:s'),
            "online_endview" => date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes")),
            "online_ip" => $_SERVER['REMOTE_ADDR'],
            "online_url" => $_SERVER['REQUEST_URI'],
            "online_agent" => $_SERVER['HTTP_USER_AGENT']
        ];
    }

    //Atualiza sessão do usuário!
    private function sessionUpdate()
    {
        $_SESSION['useronline']['online_endview'] = date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes"));
        $_SESSION['useronline']['online_url'] = $_SERVER['REQUEST_URI'];
    }

    /*
     * ***************************************
     * *** USUÁRIOS, VISITAS, ATUALIZAÇÕES ***
     * ***************************************
     */

    //Verifica e insere o tráfego na tabela
    private function setTraffic()
    {
        $this->getTraffic();

        if (!$this->Traffic):
            $this->siteViews->siteviews_date = $this->Date;
            $this->siteViews->siteviews_users = 1;
            $this->siteViews->siteviews_views = 1;
            $this->siteViews->siteviews_pages = 1;
            $this->siteViews->save();
        else:
            $this->siteViews->findById($this->Traffic->siteviews_id);
            if (!$this->getCookie()):
                $this->siteViews->siteviews_users = $this->Traffic->siteviews_users + 1;
                $this->siteViews->siteviews_views = $this->Traffic->siteviews_views + 1;
                $this->siteViews->siteviews_pages = $this->Traffic->siteviews_pages + 1;
            else:
                $this->siteViews->siteviews_views = $this->Traffic->siteviews_views + 1;
                $this->siteViews->siteviews_pages = $this->Traffic->siteviews_pages + 1;
            endif;

            $this->siteViews->save();;
        endif;
    }

    //Verifica e atualiza os pageviews
    private function TrafficUpdate()
    {
        $this->getTraffic();
        $this->siteViews->findById($this->Traffic->siteviews_id);
        $this->siteViews->siteviews_pages = $this->Traffic->siteviews_pages + 1;
        $this->siteViews->save();
        $this->Traffic = null;
    }

    //Obtém dados da tabele [ HELPER TRAFFIC ]
    //ws_siteviews
    private function getTraffic()
    {
        $list = $this->siteViews->find("siteviews_date = :date", "date={$this->Date}")->limit(1)->fetch(true);
        if ($list):
            foreach ($list as $d) {
                $this->Traffic = $d->data();
            }
        endif;
    }

    //Verifica, cria e atualiza o cookie do usuário [ HELPER TRAFFIC ]
    private function getCookie()
    {
        $Cookie = filter_input(INPUT_COOKIE, 'useronline', FILTER_DEFAULT);
        setcookie("useronline", base64_encode("ministart"), time() + 86400);
        if (!$Cookie):
            return false;
        else:
            return true;
        endif;
    }

    /*
     * ***************************************
     * *******  NAVEGADORES DE ACESSO   ******
     * ***************************************
     */

    //Identifica navegador do usuário!
    private function CheckBrowser()
    {
        $this->Browser = $_SESSION['useronline']['online_agent'];
        if (strpos($this->Browser, 'Chrome')):
            $this->Browser = 'Chrome';
        elseif (strpos($this->Browser, 'Firefox')):
            $this->Browser = 'Firefox';
        elseif (strpos($this->Browser, 'MSIE') || strpos($this->Browser, 'Trident/')):
            $this->Browser = 'IE';
        else:
            $this->Browser = 'Outros';
        endif;
    }

    //Atualiza tabela com dados de navegadores!
    private function BrowserUpdate()
    {
        $list = $this->siteViewsAgent->find("agent_name = :agent", "agent={$this->Browser}")->limit(1)->fetch(true);

        if ($list):
            foreach ($list as $d) {
                $readAgent = $d->data();
            }
            $this->siteViewsAgent->findById($readAgent->agent_id);
            $this->siteViewsAgent->agent_views = $readAgent->agent_views + 1;
            $this->siteViewsAgent->save();
        else:
            $this->siteViewsAgent->agent_name = $this->Browser;
            $this->siteViewsAgent->agent_views = 1;
            $this->siteViewsAgent->save();
        endif;
    }

    /*
     * ***************************************
     * *********   USUÁRIOS ONLINE   *********
     * ***************************************
     */

    //Cadastra usuário online na tabela!
    private function setUsuario()
    {
        $this->siteViewsOnline->online_session = $_SESSION['useronline']['online_session'];
        $this->siteViewsOnline->online_startview = $_SESSION['useronline']['online_startview'];
        $this->siteViewsOnline->online_endview = $_SESSION['useronline']['online_endview'];
        $this->siteViewsOnline->online_ip = $_SESSION['useronline']['online_ip'];
        $this->siteViewsOnline->online_url = $_SESSION['useronline']['online_url'];
        $this->siteViewsOnline->online_agent = $_SESSION['useronline']['online_agent'];
        $this->siteViewsOnline->agent_name = $this->Browser;
        $this->siteViewsOnline->save();
    }

    //Atualiza navegação do usuário online!
    private function UsuarioUpdate()
    {
        $list = $this->siteViewsOnline->find("online_session = :ses", "ses={$_SESSION['useronline']['online_session']}")->limit(1)->fetch(true);

        if ($list):
            foreach ($list as $d) {
                $readOnline = $d->data();
            }
            $this->siteViewsOnline->findById($readOnline->online_id);
            $this->siteViewsOnline->online_endview = $_SESSION['useronline']['online_endview'];
            $this->siteViewsOnline->online_url = $_SESSION['useronline']['online_url'];
            $this->siteViewsOnline->save();
        else:
            $this->setUsuario();
        endif;
    }

}
