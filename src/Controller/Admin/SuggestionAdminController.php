<?php
namespace SuggestionBundle\Controller\Admin;

use RootBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SuggestionAdminController extends AbstractController{

    #[Route("/admin/suggestions", name:"admin.suggestions", methods: ["GET"], priority: 100)]
    public function index()
    {
        return $this->render("@Suggestion/admin-index");
    }
}