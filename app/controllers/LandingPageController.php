<?php

class LandingpageController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        $data = [
            'title' => "Phone shop"
        ];
        $this->view('landingpages/index', $data);
    }
}