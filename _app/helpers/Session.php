<?php

namespace App\Helpers;

use App\Conn\Read;
use App\Conn\Create;
use App\Conn\Update;

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
    private $TenantId;

    /**
     * Session constructor.
     * @param null $Cache
     * @param int $Tenant
     */
    function __construct($Cache = null, $Tenant = 0)
    {
        // session_start(); a sessão é iniciada no componente Auth
        $this->TenantId = $Tenant;
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
            "tenant_id" => $this->TenantId,
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
            $ArrSiteViews = ['tenant_id' => $this->TenantId, 'siteviews_date' => $this->Date, 'siteviews_users' => 1, 'siteviews_views' => 1, 'siteviews_pages' => 1];
            $createSiteViews = new Create;
            $createSiteViews->ExeCreate('sm_siteviews', $ArrSiteViews);
        else:
            if (!$this->getCookie()):
                $ArrSiteViews = ['tenant_id' => $this->TenantId, 'siteviews_users' => $this->Traffic['siteviews_users'] + 1, 'siteviews_views' => $this->Traffic['siteviews_views'] + 1, 'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1];
            else:
                $ArrSiteViews = ['tenant_id' => $this->TenantId, 'siteviews_views' => $this->Traffic['siteviews_views'] + 1, 'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1];
            endif;

            $updateSiteViews = new Update;
            $updateSiteViews->ExeUpdate('sm_siteviews', $ArrSiteViews, "WHERE siteviews_date = :date", "date={$this->Date}");

        endif;
    }

    //Verifica e atualiza os pageviews
    private function TrafficUpdate()
    {
        $this->getTraffic();
        $ArrSiteViews = ['tenant_id' => $this->TenantId, 'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1];
        $updatePageViews = new Update;
        $updatePageViews->ExeUpdate('sm_siteviews', $ArrSiteViews, "WHERE siteviews_date = :date", "date={$this->Date}");

        $this->Traffic = null;
    }

    //Obtém dados da tabele [ HELPER TRAFFIC ]
    //ws_siteviews
    private function getTraffic()
    {
        $readSiteViews = new Read;
        $readSiteViews->ExeRead('sm_siteviews', "WHERE siteviews_date = :date", "date={$this->Date}");
        if ($readSiteViews->getRowCount()):
            $this->Traffic = $readSiteViews->getResult()[0];
        endif;
    }

    //Verifica, cria e atualiza o cookie do usuário [ HELPER TRAFFIC ]
    private function getCookie()
    {
        $Cookie = filter_input(INPUT_COOKIE, 'useronline', FILTER_DEFAULT);
        setcookie("useronline", base64_encode("startmelo"), time() + 86400);
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
        $readAgent = new Read;
        $readAgent->ExeRead('sm_siteviews_agent', "WHERE agent_name = :agent", "agent={$this->Browser}");
        if (!$readAgent->getResult()):
            $ArrAgent = ['tenant_id' => $this->TenantId, 'agent_name' => $this->Browser, 'agent_views' => 1];
            $createAgent = new Create;
            $createAgent->ExeCreate('sm_siteviews_agent', $ArrAgent);
        else:
            $ArrAgent = ['tenant_id' => $this->TenantId, 'agent_views' => $readAgent->getResult()[0]['agent_views'] + 1];
            $updateAgent = new Update;
            $updateAgent->ExeUpdate('sm_siteviews_agent', $ArrAgent, "WHERE agent_name = :name", "name={$this->Browser}");
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
        $sesOnline = $_SESSION['useronline'];
        $sesOnline['agent_name'] = $this->Browser;
        $sesOnline['tenant_id'] = $this->TenantId;

        $userCreate = new Create;
        $userCreate->ExeCreate('sm_siteviews_online', $sesOnline);
    }

    //Atualiza navegação do usuário online!
    private function UsuarioUpdate()
    {
        $ArrOnlone = [
            'online_endview' => $_SESSION['useronline']['online_endview'],
            'online_url' => $_SESSION['useronline']['online_url'],
            'tenant_id' => $this->TenantId
        ];

        $userUpdate = new Update;
        $userUpdate->ExeUpdate('sm_siteviews_online', $ArrOnlone, "WHERE online_session = :ses", "ses={$_SESSION['useronline']['online_session']}");

        if (!$userUpdate->getRowCount()):
            $readSes = new Read;
            $readSes->ExeRead('sm_siteviews_online', 'WHERE online_session = :onses', "onses={$_SESSION['useronline']['online_session']}");
            if (!$readSes->getRowCount()):
                $this->setUsuario();
            endif;
        endif;
    }

}
