<?php
namespace Page;

class Login
{
    // include url of current page
    public static $URL = '/customer/account/login/';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $emailField = "login[username]";


    public static $passwordField = "login[password]";

    public static $rememberMeField = "persist_remember_me";

    public static $loginBtn = "send";

    public static $forgotPasswordLink = "/customer/account/forgotpassword/";

    public static $loginPopupLink = "ul > li.authorization-link.signin > a";

    /**
     * @var \AcceptanceTester
     */
    protected $tester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
    }


    public function loginViaModal($email,$password){
        $I = $this->tester;
        if($I->loadSessionSnapshot("login")){
            return;
        }
        $I->click(self::$loginPopupLink);
        return $this->login($email,$password);
    }

    public function loginViaPage($email,$password){
        $I = $this->tester;
        if($I->loadSessionSnapshot("login")){
            return;
        }
        $I->amOnPage(self::$URL);
        return $this->login($email,$password);
    }

    protected function login($email,$password){
        $I = $this->tester;
        if($I->loadSessionSnapshot("login")){
            return;
        }
        $I->fillField(self::$emailField,$email);
        $I->fillField(self::$passwordField,$password);
        $I->click(self::$loginBtn);
        $I->saveSessionSnapshot("login");
        return $this;
    }



}