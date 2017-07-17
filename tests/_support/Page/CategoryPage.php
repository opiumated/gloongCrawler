<?php
namespace Page;

class CategoryPage
{

    public static $productGridElem = ["css"=>"div.product-item-info"];

    public static $firstProductGrid = "ol.products > li:nth-child(1)";

    public static $miniCartQtyElem = "span.counter-label";
    //public static $miniCartQtyElem = "span.counter-number";


    protected $tester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    protected function mouseOverProduct($gridPosition=1){
        $I = $this->tester;
        $I->moveMouseOver("ol.products > li:nth-child({$gridPosition})");
        return $this;
    }

    public function addToCart($productSelector){
        $I = $this->tester;
       // $I->loadSessionSnapshot('cart');
        //$I->wait(15);

        $cartQty = (int) $I->grabTextFrom(self::$miniCartQtyElem);
       $I->moveMouseOver(['css' => "{$productSelector}"]);
        $I->seeElement("{$productSelector} span.add-action.fa.fa-plus");

        $I->click("{$productSelector} span.add-action.fa.fa-plus");
        $I->wait("25");
        $I->see($cartQty+1,self::$miniCartQtyElem);
       // $I->saveSessionSnapshot('cart');
        return $this;
    }

    public function addFirstSetOfProductsToCart($noOfProducts){
        $i = 1;
        for($i; $i<=$noOfProducts; $i++){
            $productSelector = "ol.products > li:nth-child({$i})";
            $this->addToCart($productSelector);
        }
        return $this;
    }

    private function getCartQty(){
        $I = $this->tester;
        $I->loadSessionSnapshot('cart');
        $qty = (int) $I->grabTextFrom(self::$miniCartQtyElem);
        codecept_debug($qty);
        return $qty ;
    }

}
