<?php


class CategoryPageAddToCartCest
{
    const DEFAULT_TIMEOUT = 15;

    public function _before(AcceptanceTester $I)
    {

    }

    public function _after(AcceptanceTester $I)
    {

    }

    // tests
    public function GroceriesShopTest(AcceptanceTester $I)
    {
        $I->wantTo("Test Add To Cart on Food and Drinks Page");
        $this->_testCategoryPage($I, "/groceries.html", "Food, Drinks & Groceries Nigeria - Shop Food & Drinks Online Supermarket | Best prices | Gloo.ng",1);
    }

    public function LargeAppliancesTest(AcceptanceTester $I){
        $I->wantTo("Test Large Appliances Page");
        $this->_testCategoryPage($I,"/home-large-appliances.html","Large Appliances Nigeria - Buy Large Appliances Online | Gloo.ng",1);
    }


    public function _testCategoryPage(AcceptanceTester $I,$url,$expectedTitle,$cartCount){
        $I->amOnPage($url);
        $I->seeInTitle($expectedTitle);
        $I->moveMouseOver("ol.products > li:nth-child(1)");
        $I->seeElement("ol.products > li:nth-child(1) span.add-action");
        $I->click("ol.products > li:nth-child(1) span.add-action");
        $I->wait(self::DEFAULT_TIMEOUT);
        $I->see($cartCount, "span.counter-label");
        return $I;
    }
}
