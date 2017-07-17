<?php


class CheckoutCest
{
    public function _before(AcceptanceTester $I)
    {
      //  $I->amOnPage("/");
        //$I->resetCookie('cart');
    }

    public function _after(AcceptanceTester $I)
    {

    }
    /**
     * @param AcceptanceTester $I
     *
     */
    public function existingUserCheckout(AcceptanceTester $I, \Page\CategoryPage $categoryPage){
        //$I->loadSessionSnapshot("cart");
        $I->wantTo("Checkout as an Existing User");

        //Add to Cart
        $I->amOnPage("/home-large-appliances.html");
        $categoryPage->addToCart($categoryPage::$firstProductGrid);
        //Make snapshot
        $I->amOnPage('/checkout/cart');
        $I->makeScreenshot("cart-page");


        $I->amOnPage("/checkout");
        $I->wait(5);
        $this->checkoutLogin($I,"yourgloo.ngusername","yourgloo.ngpassword");
        $I->wait(15);
        $I->selectOption("#s_method_freeshipping_freeshipping","freeshipping_freeshipping");
        $I->wait(5);
        $I->wait(10);
        $I->selectOption("#cashondelivery","Payment on Delivery (Cash, POS or GTB*737)");
        $I->makeScreenshot("payment-methods");
        $I->wait(8);
        $I->scrollTo("#onestepcheckout-button-place-order");
        $I->click("#onestepcheckout-button-place-order");
        $I->wait("30");
        $I->see("Your order number is","#maincontent > div.columns > div > div.checkout-success > p:nth-child(1)");

    }

    protected function checkoutLogin(AcceptanceTester $I,$email,$password=""){

        if($I->loadSessionSnapshot("login")){
            return;
        }
        $I->fillField("#customer-email",$email);

        $I->wait(25);
            $I->seeElement(["css" => "div#onestepcheckout-login-popup-contents-login"]);
            $I->fillField("#id_onestepcheckout_password", $password);
            $I->click("#onestepcheckout-login-button");
            $I->wait("15");
            //Select the first address
            $I->seeElement(["css" => "div.shipping-address-item"]);
            //$I->click(".shipping-address-item:nth-of-type(4)");
            //$I->wait(22);
            $I->click("#onestepcheckout-button-place-order");
            echo "Place order has been clicked";
            $I->wait(20);

            $I->saveSessionSnapshot("login");
        return $this;
    }

}
