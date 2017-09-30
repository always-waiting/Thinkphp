<?php
namespace app\Test\controller;

class Index
{
    public function index()
    {
        $Test = new \my\Test();
        $Test->sayHello();
        return "<br>This is mixichao testing!";
    }
}
