<?php
/**
 * @category    Pimcore Plugin
 * @date        13/06/2017 15:49
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */


/**
 * Class GoogleLogin_IndexController
 *
 * Based on OAuth2 Client Example - nothing sophisticated
 *
 * @package GoogleLogin
 */
class GoogleLogin_IndexController extends \Pimcore\Controller\Action
{

    protected $config;

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        $configHelper = new \GoogleLogin\Helper\Config();
        $this->config = $configHelper->getConfig();

        parent::__construct($request, $response, $invokeArgs);
    }

    /**
     * @return \GoogleLogin\OAuth2\Client\Provider\Google
     */
    protected function getProvider()
    {
        $provider = new \GoogleLogin\OAuth2\Client\Provider\Google([
            'clientId'     => $this->config->clientId,
            'clientSecret' => $this->config->clientSecret,
            'redirectUri'  => $this->config->redirectUri,
            'hostedDomain' => $this->config->hostedDomain,
        ]);

        return $provider;
    }

    protected function loginUser(string $email)
    {
        $user = \Pimcore\Model\User::getByName($email, 1);
        if(!$user) {
            $user = new \Pimcore\Model\User\Listing();
            $user->setCondition("email = ?", $email);
            $user->load();
            $user = $user->getUsers()[0];
        }
        if($user && $user->isActive()) {
            /** Log in user */
            Pimcore\Tool\Session::useSession(function ($adminSession) use ($user) {
                $adminSession->user = $user;
            });
            Pimcore\Tool\Session::regenerateId();
            $this->redirect("/admin/?_dc=" . time());
        } else {
            $this->redirect("/admin/login/?auth_failed=true&reason=no_user");
        }
    }

    public function indexAction()
    {
        $provider = $this->getProvider();

        if ($this->getParam('error')) {

            // Got an error, probably user denied access
            $this->redirect("/admin/?auth_failed=true&reason=access_denied");

        } elseif (!$this->getParam('code')) {

            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: ' . $authUrl);
            exit;

        } else {

            // Try to get an access token (using the authorization code grant)
            try {
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
            } catch (Exception $e) {
                $this->redirect("/admin/login/?auth_failed=true&reason=bad_token");
            }

            // Now you have a token you can look up a users profile data
            try {

                // We got an access token, let's now get the owner details
                /** @var \League\OAuth2\Client\Provider\GenericResourceOwner $ownerDetails */
                $ownerDetails = $provider->getResourceOwner($token);

                $domain = $ownerDetails->toArray()["domain"];
                $email = $ownerDetails->toArray()["emails"][0]["value"];

                if($domain == $this->config->hostedDomain) {
                    $this->loginUser($email);
                }

            } catch (Exception $e) {
                // Failed to get user details
                exit('Something went wrong: ' . $e->getMessage());
                $this->redirect("/admin/login/?auth_failed=true&reason=user_details");
            }

            $this->redirect("/admin/?auth_failed=true");
        }
    }

    /**
     * Display login form. And some errors.
     */
    public function loginAction()
    {
        if ($this->getParam("auth_failed")) {
            $this->view->error = "error_auth_failed";
        }
        if ($this->getParam("session_expired")) {
            $this->view->error = "error_session_expired";
        }
    }
}
