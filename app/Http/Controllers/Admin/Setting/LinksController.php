<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\Setting\LinksRepository;

class LinksController extends Controller
{

    protected $linksRepository;

    public function __construct(LinksRepository $linksRepository)
    {
        $this->linksRepository = $linksRepository;
    }

    public function index()
    {
        $data = $this->linksRepository->getAllLinksInCache();
        dump($data);
    }

}
